<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? (\App\Models\SchoolSetting::current()->school_name ?? 'Darul Fikri') }}</title>
    <meta name="description" content="{{ $description ?? 'Sekolah Islam ' . (\App\Models\SchoolSetting::current()->school_name ?? 'Darul Fikri') . ' - Pendidikan berkualitas dari RTK hingga SMA.' }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-white text-slate-800 antialiased">
    {{ $slot }}

    @if($showFooter ?? false)
        <x-footer />
    @endif

    <x-lightbox />
    @if($showBackToTop ?? true)
        <x-back-to-top />
    @endif
</body>
</html>
