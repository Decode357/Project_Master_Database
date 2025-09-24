<!doctype html>
<html>

<head>
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Public+Sans%3Awght%40400%3B500%3B700%3B900"
        onload="this.rel='stylesheet'" rel="stylesheet" />
    <title>Stitch Design</title>
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">
    <div class="relative flex size-full min-h-screen flex-col bg-gray-50 group/design-root overflow-x-hidden"
        style='font-family: "Public Sans", "Noto Sans", sans-serif;'>
        <div class="layout-container flex h-full grow flex-col">
            <div class="px-4 flex flex-1 justify-center items-center py-5">
                <div class="layout-content-container flex flex-col w-full max-w-md py-5 space-y-6">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-gray-900">PATRA</h1>
                        <h2 class="mt-2 text-xl font-semibold text-gray-800">Product Master Data</h2>
                        <p class="mt-2 text-sm text-gray-600">Please sign in to continue</p>
                    </div>
                    <div class="bg-white p-8 rounded-2xl shadow-lg w-full">
                        <form class="space-y-6">
                            <div>
                                <label class="sr-only" for="email">Email</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        mail </span>
                                    <input autocomplete="email"
                                        class="form-input block w-full rounded-full border-gray-300 bg-gray-50 py-3 pl-10 pr-3 text-gray-900 placeholder-gray-500 focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm"
                                        id="email" name="email" placeholder="Email" required=""
                                        type="email" />
                                </div>
                            </div>
                            <div>
                                <label class="sr-only" for="password">Password</label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        lock </span>
                                    <input autocomplete="current-password"
                                        class="form-input block w-full rounded-full border-gray-300 bg-gray-50 py-3 pl-10 pr-3 text-gray-900 placeholder-gray-500 focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm"
                                        id="password" name="password" placeholder="Password" required=""
                                        type="password" />
                                </div>
                            </div>
                            <div>
                                <fieldset>
                                    <legend class="sr-only">Role</legend>
                                    <div class="flex items-center justify-center rounded-full bg-gray-100 p-1">
                                        <label
                                            class="flex flex-1 cursor-pointer items-center justify-center rounded-full px-4 py-2 text-sm font-medium text-gray-500 transition-colors has-[:checked]:bg-white has-[:checked]:text-gray-900 has-[:checked]:shadow-sm">
                                            <input checked="" class="sr-only" name="role" type="radio"
                                                value="User" />
                                            <span>User</span>
                                        </label>
                                        <label
                                            class="flex flex-1 cursor-pointer items-center justify-center rounded-full px-4 py-2 text-sm font-medium text-gray-500 transition-colors has-[:checked]:bg-white has-[:checked]:text-gray-900 has-[:checked]:shadow-sm">
                                            <input class="sr-only" name="role" type="radio" value="Admin" />
                                            <span>Admin</span>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>
                            <div>
                                <a href="{{ route('dashboard') }}"
                                    class="btn flex w-full justify-center rounded-full bg-[#ea2a33] py-3 px-4 text-sm font-semibold text-white shadow-sm hoverScale hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    Login
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
