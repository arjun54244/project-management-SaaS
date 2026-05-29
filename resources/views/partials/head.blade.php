<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<script>
    (function () {
        const accent = localStorage.getItem('theme-custom-accent');
        if (accent) {
            document.documentElement.style.setProperty('--custom-accent', accent);
            try {
                const num = parseInt(accent.replace('#',''), 16);
                const r = Math.min(255, (num >> 16) + 35);
                const g = Math.min(255, ((num >> 8) & 0x00FF) + 35);
                const b = Math.min(255, (num & 0x0000FF) + 35);
                const accentLight = '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
                document.documentElement.style.setProperty('--custom-accent-light', accentLight);
            } catch (e) {
                console.error(e);
            }
        }
    })();
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<script>
    (function () {
        const customApply = function (appearance) {
            const themeClasses = ['dark', 'midnight', 'ocean', 'forest', 'rose', 'sunset', 'lavender', 'custom'];
            document.documentElement.classList.remove(...themeClasses);
            
            if (appearance === 'system') {
                window.localStorage.removeItem('flux.appearance');
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                }
            } else {
                window.localStorage.setItem('flux.appearance', appearance);
                if (themeClasses.includes(appearance)) {
                    document.documentElement.classList.add(appearance);
                }
            }
        };
        
        if (window.Flux) {
            window.Flux.applyAppearance = customApply;
        } else {
            window.Flux = { applyAppearance: customApply };
        }
        
        const savedTheme = window.localStorage.getItem('flux.appearance') || 'system';
        window.Flux.applyAppearance(savedTheme);
    })();
</script>
