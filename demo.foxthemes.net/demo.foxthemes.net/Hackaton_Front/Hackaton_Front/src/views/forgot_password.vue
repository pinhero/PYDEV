<template>
   
                <div class="flex flex-col h-screen justify-center items-center">


                    <div class="max-w-sm mx-auto md:px-10 p-4 w-full">


                        <div>

                            <!-- logo -->
                            <div class="flex justify-center mb-12">
                                <img src="assets/images/logo.png" alt=""
                                    class="w-auto h-16 shrink-0 bg-fuchsia-100 px-3 rounded-2xl p-2.5">
                            </div>

                            <form method="#" action="#" class="space-y-3">

                                <input class="!w-full h-10 border-gray-400 border-2 rounded-md p-1 " id="username" name="username" type="text" autofocus=""
                                    placeholder="username" required="">
                                <input class="!w-full h-10 border-gray-400 border-2 rounded-md p-1" id="name" name="name" type="text" autofocus="" placeholder="Full name"
                                    required="">
                                <input class="!w-full h-10 border-gray-400 border-2 rounded-md p-1" id="email" name="email" type="email" autofocus="" placeholder="Email"
                                    required="">
                                <input class="!w-full h-10 border-gray-400 border-2 rounded-md p-1 " id="password" name="password" type="password" autofocus=""
                                    placeholder="Password" required="">

                                <a href="#" class="hidden">
                                    <div class="text-sm text-right text-gray-400 py-4"> Forget password </div>
                                </a>

                                <button type="submit"
                                    class="font-medium w-full  hover:bg-white hover:border-slate-900 hover:border-2 hover:text-slate-900 rounded-lg  bg-slate-900 py-1.5 px-4 text-white h-[38px] active:scale-[0.97] transition-all duration-150">
                                    <span>Get Started</span> </button>

                                <div class="space-x-2 text-sm text-center text-slate-400 dark:text-white/70">
                                    <span> i have account? </span>
                                    <span>—</span>
                                    <a href="form-login.html" class="text-gray-600 hover:text-gray-500">Login</a>

                                </div>
                            </form>


                        </div>


                    </div>

            </div> 
</template>
<script>
export default {

}
</script>