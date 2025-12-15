<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-indigo-600 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-white">
                            <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-indigo-200">
                                Admin Dashboard
                            </a>
                        </h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-white">Welcome, {{ auth('admin')->user()->name }}</span>
                        <a href="{{ route('admin.profile.edit') }}" class="text-white hover:text-indigo-200">Profile</a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-white hover:text-indigo-200">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Profile Settings</h2>
                    </div>
                    
                    <div class="p-6 space-y-8">
                        <!-- Profile Information -->
                        <div class="bg-white p-6 rounded-lg border border-gray-200">
                            <header class="mb-4">
                                <h2 class="text-lg font-medium text-gray-900">
                                    Profile Information
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Update your account's profile information and email address.
                                </p>
                            </header>

                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('patch')

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input id="name" name="name" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('name', $admin->name) }}" required autofocus autocomplete="name">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input id="email" name="email" type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('email', $admin->email) }}" required autocomplete="username">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    @if ($admin instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $admin->hasVerifiedEmail())
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-800">
                                                Your email address is unverified.

                                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Click here to re-send the verification email.
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 font-medium text-sm text-green-600">
                                                    A new verification link has been sent to your email address.
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Save</button>

                                    @if (session('status') === 'profile-updated')
                                        <p class="text-sm text-green-600">Saved.</p>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Update Password -->
                        <div class="bg-white p-6 rounded-lg border border-gray-200">
                            <header class="mb-4">
                                <h2 class="text-lg font-medium text-gray-900">
                                    Update Password
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Ensure your account is using a long, random password to stay secure.
                                </p>
                            </header>

                            <form method="post" action="{{ route('admin.profile.password.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('put')

                                <div>
                                    <label for="update_password_current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                    <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" autocomplete="current-password">
                                    @error('current_password', 'updatePassword')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="update_password_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                    <input id="update_password_password" name="password" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" autocomplete="new-password">
                                    @error('password', 'updatePassword')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" autocomplete="new-password">
                                    @error('password_confirmation', 'updatePassword')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Save</button>

                                    @if (session('status') === 'password-updated')
                                        <p class="text-sm text-green-600">Saved.</p>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Delete Account -->
                        <div class="bg-white p-6 rounded-lg border border-red-200">
                            <header class="mb-4">
                                <h2 class="text-lg font-medium text-gray-900">
                                    Delete Account
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                                </p>
                            </header>

                            <button
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                onclick="document.getElementById('confirm-admin-deletion').style.display='block'"
                            >Delete Account</button>

                            <!-- Confirmation Modal -->
                            <div id="confirm-admin-deletion" style="display: none;" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                    <div class="mt-3">
                                        <h3 class="text-lg font-medium text-gray-900 text-center">Delete Account</h3>
                                        <div class="mt-2 px-7 py-3">
                                            <p class="text-sm text-gray-500">
                                                Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                                            </p>
                                            
                                            <form method="post" action="{{ route('admin.profile.destroy') }}" class="mt-4">
                                                @csrf
                                                @method('delete')

                                                <div class="mt-6">
                                                    <label for="password" class="sr-only">Password</label>
                                                    <input
                                                        id="password"
                                                        name="password"
                                                        type="password"
                                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                                        placeholder="Password"
                                                    >
                                                    @error('password', 'adminDeletion')
                                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div class="flex items-center justify-end mt-6">
                                                    <button type="button" onclick="document.getElementById('confirm-admin-deletion').style.display='none'" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                                        Cancel
                                                    </button>

                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Delete Account
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>