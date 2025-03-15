<!DOCTYPE html>
<html lang="en">

<head>
    <title>My App</title>
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite('resources/css/app.css') {{-- ✅ This loads Tailwind CSS via Vite --}}
    <body>
    @livewire('management')
    @livewireScripts
</body>

</html>