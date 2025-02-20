<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>404 - Page Not Found</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-customGreenDark dark:bg-customGreenLight flex items-center justify-center min-h-screen">
  <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-10 max-w-xl mx-4">
    <div class="text-center">
      <h1 class="text-6xl font-extrabold text-blue-600 dark:text-blue-300 mb-4">404</h1>
      <p class="text-xl text-gray-700 dark:text-gray-300 mb-6">
        Oops! We couldn’t find the page you were looking for.
      </p>
      <div class="flex flex-col sm:flex-row sm:justify-center gap-4">
        <a href="{{ url('/') }}"
           class="px-6 py-3 bg-blue-600 dark:bg-blue-500 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 transition">
          Home
        </a>
        <a href="{{ url('/contact') }}"
           class="px-6 py-3 bg-green-600 dark:bg-green-500 text-white rounded-md hover:bg-green-700 dark:hover:bg-green-600 transition">
          Contact Support
        </a>
        <a href="{{ url('/faq') }}"
           class="px-6 py-3 bg-purple-600 dark:bg-purple-500 text-white rounded-md hover:bg-purple-700 dark:hover:bg-purple-600 transition">
          FAQ
        </a>
      </div>
      <div class="mt-8">
        <p class="text-sm text-gray-500 dark:text-gray-400">
          If you believe this is an error, please <a href="{{ url('/report') }}"
             class="text-blue-500 underline hover:text-blue-700 dark:hover:text-blue-400">
            report it here
          </a>.
        </p>
      </div>
    </div>
  </div>
</body>

</html>
