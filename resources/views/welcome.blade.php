<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LASU CS — Final Year Project Repository</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-50 font-sans">

    {{-- Nav --}}
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <p class="font-bold text-blue-700 text-lg leading-none">LASU CS</p>
                <p class="text-xs text-gray-400">Project Repository</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-600 font-medium px-4 py-2">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="text-sm bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Register
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 text-white">
        <div class="max-w-5xl mx-auto px-6 py-20 text-center">
            <span
                class="inline-block bg-blue-500 bg-opacity-40 text-blue-100
                         text-xs font-medium px-3 py-1 rounded-full mb-4 uppercase tracking-wide">
                Lagos State University, Ojo
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                Departmental Final Year<br>Project Repository
            </h1>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                A centralized digital archive for final year projects in the
                Faculty of Science. Search, browse and access approved research
                projects from all departments.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-white text-blue-700 font-semibold px-6 py-3 rounded-lg
                          hover:bg-blue-50 transition">
                    Get Started
                </a>
                <a href="{{ route('login') }}"
                    class="border border-blue-300 text-white font-medium px-6 py-3
                          rounded-lg hover:bg-blue-600 transition">
                    Login to Browse
                </a>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="max-w-6xl mx-auto px-6 py-16">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-10">
            Everything in one place
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div
                    class="w-10 h-10 bg-blue-100 rounded-lg flex items-center
                            justify-center mb-4 text-blue-600 text-xl">
                    📁
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Submit Projects</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Students upload their final year projects with title, abstract,
                    keywords and a PDF file for supervisor review.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div
                    class="w-10 h-10 bg-green-100 rounded-lg flex items-center
                            justify-center mb-4 text-green-600 text-xl">
                    ✅
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Supervisor Review</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Assigned supervisors review, approve or reject submissions
                    and leave feedback comments for students.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div
                    class="w-10 h-10 bg-purple-100 rounded-lg flex items-center
                            justify-center mb-4 text-purple-600 text-xl">
                    🔍
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Search & Browse</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Browse approved projects by department, year or keyword.
                    Download PDFs of any approved project instantly.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div
                    class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center
                            justify-center mb-4 text-yellow-600 text-xl">
                    👥
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Role-Based Access</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Separate portals for students, supervisors, and administrators
                    with appropriate permissions for each role.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div
                    class="w-10 h-10 bg-red-100 rounded-lg flex items-center
                            justify-center mb-4 text-red-600 text-xl">
                    🔒
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Secure Storage</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Project files are stored securely and only accessible
                    to authorised users. No public file exposure.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div
                    class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center
                            justify-center mb-4 text-indigo-600 text-xl">
                    📊
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Admin Reports</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Administrators can manage users, monitor submissions,
                    track activity logs and generate departmental reports.
                </p>
            </div>

        </div>
    </section>

    {{-- How it works --}}
    <section class="bg-white border-t border-gray-100 py-16">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-10">
                How it works
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                @foreach ([['01', 'Register', 'Create your account as a student or supervisor'], ['02', 'Submit', 'Upload your project with abstract and PDF'], ['03', 'Review', 'Supervisor reviews and approves your work'], ['04', 'Archive', 'Approved projects are stored in the repository']] as [$num, $title, $desc])
                    <div>
                        <div
                            class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center
                                    justify-center font-bold text-lg mx-auto mb-3">
                            {{ $num }}
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1">{{ $title }}</h3>
                        <p class="text-sm text-gray-500">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-blue-700 text-white py-12 text-center">
        <div class="max-w-2xl mx-auto px-6">
            <h2 class="text-2xl font-bold mb-3">Ready to get started?</h2>
            <p class="text-blue-200 mb-6 text-sm">
                Register with your department email to access the repository.
            </p>
            <a href="{{ route('register') }}"
                class="bg-white text-blue-700 font-semibold px-8 py-3 rounded-lg
                      hover:bg-blue-50 transition">
                Create Account
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-gray-400 py-6 text-center text-xs">
        <p>&copy; {{ date('Y') }} Lagos State University, Ojo —
            Department of Computer Science.</p>
        <p class="mt-1">Developed by Adepemeji Samuel Adetomiwa &bull; Final Year Project</p>
    </footer>

</body>

</html>
