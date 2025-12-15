<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-indigo-600 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-white">Admin Dashboard</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-white">Welcome, {{ auth('admin')->user()->name }}</span>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white px-3 py-1 rounded text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Admin Panel</h2>
                    <p class="text-gray-600 mb-4">You are logged in as an administrator.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Users Management</h3>
                            <p class="text-gray-600">Manage application users</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Settings</h3>
                            <p class="text-gray-600">Configure application settings</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Reports</h3>
                            <p class="text-gray-600">View analytics and reports</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Authentication Info</h3>
                        <ul class="text-sm text-gray-600">
                            <li><strong>Guard:</strong> admin</li>
                            <li><strong>User ID:</strong> {{ auth('admin')->id() }}</li>
                            <li><strong>Email:</strong> {{ auth('admin')->user()->email }}</li>
                            <li><strong>Type:</strong> {{ auth('admin')->user()->type }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
