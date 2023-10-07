<?php


namespace App\Traits;


trait RulesGenerator
{
    /**
     * @param $champs
     * @return array
     */
    function generateValidationRules($champs)
    {
        $validationRules = [];
        $errorMessage = [];

        foreach ($champs as $champ) {
            $fieldName = $champ['libelle'];
            $rules = [];
            // Ajoutez des règles en fonction de la configuration
            if ($champ['contrainte'] === null) {
                $rules[] = 'nullable';
            } else {
                switch ($champ['contrainte']['contrainte']) {
                    case 'O':
                        $rules[] = 'required';
                        switch ($champ['type']) {
                            case 'Alphanumérique':
                                $rules[] = 'string';
                                if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0 && $champ['taille_max'] === $champ['taille_min']) {
                                    $rules[] = "size:{$champ['taille_min']}";
                                } else if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0) {
                                    $rules[] = "min:{$champ['taille_min']}";
                                    $rules[] = "max:{$champ['taille_max']}";
                                }
                                break;
                            case 'Alphabétique':
                                $rules[] = 'string';
                                if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0 && $champ['taille_max'] === $champ['taille_min']) {
                                    $rules[] = "size:{$champ['taille_min']}";
                                } else if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0) {
                                    $rules[] = "min:{$champ['taille_min']}";
                                    $rules[] = "max:{$champ['taille_max']}";
                                }
                                break;
                            case 'Numérique':
                                $rules[] = 'integer';
                                if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0 && $champ['taille_max'] === $champ['taille_min']) {
                                    $rules[] = "digits:{$champ['taille_min']}";
                                } else if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0) {
                                    $rules[] = "min:{$champ['taille_min']}";
                                    $rules[] = "max:{$champ['taille_max']}";
                                }
                                break;
                            default:
                                $rules[] = 'string';
                                break;
                        }
                        break;
                    case 'O*':
                        $rules[] = 'required';
                        switch ($champ['type']) {
                            case 'Alphanumérique':
                                $rules[] = 'string';
                                if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0 && $champ['taille_max'] === $champ['taille_min']) {
                                    $rules[] = "size:{$champ['taille_min']}";
                                } else if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0) {
                                    $rules[] = "min:{$champ['taille_min']}";
                                    $rules[] = "max:{$champ['taille_max']}";
                                }
                                break;
                            case 'Alphabétique':
                                $rules[] = 'string';
                                if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0 && $champ['taille_max'] === $champ['taille_min']) {
                                    $rules[] = "size:{$champ['taille_min']}";
                                } else if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0) {
                                    $rules[] = "min:{$champ['taille_min']}";
                                    $rules[] = "max:{$champ['taille_max']}";
                                }
                                break;
                            case 'Numérique':
                                $rules[] = 'integer';
                                if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0 && $champ['taille_max'] === $champ['taille_min']) {
                                    $rules[] = "digits:{$champ['taille_min']}";
                                } else if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0) {
                                    $rules[] = "min:{$champ['taille_min']}";
                                    $rules[] = "max:{$champ['taille_max']}";
                                }
                                break;
                            default:
                                $rules[] = 'string';
                                break;
                        }

                        break;
                    case 'F':
                        $rules[] = 'nullable';
                        switch ($champ['type']) {
                            case 'Alphanumérique':
                                $rules[] = 'string';
                                if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0 && $champ['taille_max'] === $champ['taille_min']) {
                                    $rules[] = "size:{$champ['taille_min']}";
                                } else if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0) {
                                    $rules[] = "min:{$champ['taille_min']}";
                                    $rules[] = "max:{$champ['taille_max']}";
                                } else if ($champ['taille_min'] === 0 || $champ['taille_max'] === 0) {
                                    $rules[] = "min:{$champ['taille_min']}+{$champ['taille_max']}";
                                }
                                break;
                            case 'Alphabétique':
                                $rules[] = 'string';
                                if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0 && $champ['taille_max'] === $champ['taille_min']) {
                                    $rules[] = "size:{$champ['taille_min']}";
                                } else if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0) {
                                    $rules[] = "min:{$champ['taille_min']}";
                                    $rules[] = "max:{$champ['taille_max']}";
                                } else if ($champ['taille_min'] === 0 || $champ['taille_max'] === 0) {
                                    $rules[] = "min:{$champ['taille_min']}+{$champ['taille_max']}";
                                }
                                break;
                            case 'Numérique':
                                $rules[] = 'integer';
                                if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0 && $champ['taille_max'] === $champ['taille_min']) {
                                    $rules[] = "digits:{$champ['taille_min']}";
                                } else if ($champ['taille_min'] > 0 && $champ['taille_max'] > 0) {
                                    $rules[] = "min:{$champ['taille_min']}";
                                    $rules[] = "max:{$champ['taille_max']}";
                                } else if ($champ['taille_min'] === 0 || $champ['taille_max'] === 0) {
                                    $rules[] = "min:{$champ['taille_min']}+{$champ['taille_max']}";
                                }
                                break;
                            default:
                                $rules[] = 'string';
                                break;
                        }
                        break;
                    case '_':
                        $rules[] = 'in:NA,N/A,NAN';
                        break;
                    default:
                        $rules[] = 'in:NA,N/A,NAN';
                        break;
                }
            }

            $validationRules[$fieldName] = $rules;
            $customErrorMessages[$champ['libelle']] = $champ['description'];
        }

        return [$validationRules, $customErrorMessages];
    }
}
