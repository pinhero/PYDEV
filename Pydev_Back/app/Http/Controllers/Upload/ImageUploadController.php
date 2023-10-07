<?php

namespace App\Http\Controllers\Upload;


use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use phpseclib\Crypt\RSA as LegacyRSA;
use phpseclib3\Crypt\RSA;
use Illuminate\Support\Facades\Response;



class ImageUploadController extends BaseController
{
    
    public function storeFile(Request $request)
    {
        $this->validate($request, [
            'fichier' => 'required|mimes:pdf,ogg,avi,png'
        ]);
        $extension       = $request->file('fichier')->getClientOriginalExtension();
        $file_name       = uniqid() . '.' . $extension;
        $path = $request->file('fichier')->storeAs('uploads',$file_name,'public');
        return response()->json(['image'=> $file_name]);
    }

    public function deleteFile($name)
    {
        if (Storage::delete("uploads/$name")) {
            return  response()->json(['message' => true]);
        }
        return response()->json(['message' => false]);
    }

    /**
     * The storage location of the encryption keys.
     *
     * @var string
     */
    public static $keyPath;

    /**
     * The location of the encryption keys.
     *
     * @param  string  $file
     * @return string
     */
    public static function keyPath($file)
    {
        $file = ltrim($file, '/\\');

        return static::$keyPath
            ? rtrim(static::$keyPath, '/\\').DIRECTORY_SEPARATOR.$file
            : storage_path($file);
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function generate()
    {
        [$publicKey, $privateKey] = [
            $this->keyPath('test-public.key'),
            $this->keyPath('test-private.key'),
        ];
            if (class_exists(LegacyRSA::class)) {
                $keys = (new LegacyRSA)->createKey(4096);

                file_put_contents($publicKey, Arr::get($keys, 'publickey'));
                file_put_contents($privateKey, Arr::get($keys, 'privatekey'));
            } else {
                $key = RSA::createKey(4096);

                file_put_contents($publicKey, (string) $key->getPublicKey());
                file_put_contents($privateKey, (string) $key);
            }

            echo('Clés générées avec succès');

        return 0;
    }

    public function getKey()
    {
        $result = $this->generate();
        return $result;

    }
    public function storeEncFile(Request $request){
        // Récupérer le fichier depuis le formulaire
        $uploadedFile = $request->file('file');
        // Lire le contenu du fichier
        $content = file_get_contents($uploadedFile->getPathname());
        $publicKey = file_get_contents(storage_path('test-public.key'));
        // The encryption method
        $method = 'AES-256-CBC';
        // The IV
        $iv = '4921a67c51de4c8b';
        echo($iv);
        // Créer une instance RSA ave// The encrypted data
        $encryptedData = openssl_encrypt($content, $method, $publicKey, OPENSSL_RAW_DATA, $iv);
        // Print the encrypted data
        $extension       = $request->file('file')->getClientOriginalExtension();
        $file_name       = "chiffred_".uniqid() . '.' . $extension;
        $path = Storage::path("public/uploads/$file_name");
        file_put_contents($path, $encryptedData);
        return response()->json(['file'=> $file_name]);
    }

    public function getEncFile(string $name){
        // Chemin complet vers le fichier chiffré
        $encryptedFileFullPath = Storage::path('public/uploads/'.$name);
        // Lire le contenu chiffré du fichier
        $encryptedContent = file_get_contents($encryptedFileFullPath);

        // Charger la clé privée
        $privateKey = file_get_contents(storage_path('test-public.key'));
        // Déchiffrer le contenu avec la clé privée
        $method = 'AES-256-CBC';
        // The IV
        $iv = '4921a67c51de4c8b';
        // Créer une instance RSA ave// The encrypted data
        $decryptedContent = openssl_decrypt($encryptedContent, $method, $privateKey, OPENSSL_RAW_DATA, $iv);
        // Print the encrypted data
        // Définir le nom du fichier PDF déchiffré pour le téléchargement
        $fileName = 'de'.$name;
        // Renvoyer le fichier PDF déchiffré en tant que téléchargement
        return Response::make($decryptedContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
    

}
