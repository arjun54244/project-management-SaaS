<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Appearance Settings') }}</flux:heading>

    <x-settings.layout :heading="__('Appearance')" :subheading="__('Choose a theme that matches your style')">

        <div
            x-data="{
                customAccent: localStorage.getItem('theme-custom-accent') ?? '#818cf8',

                presets: [
                    {
                        id: 'light', name: 'Light',
                        bg: '#ffffff', sidebar: '#f5f5f5', border: '#e5e5e5',
                        text: '#171717', accent: '#404040',
                        swatches: ['#ffffff', '#f5f5f5', '#e5e5e5', '#404040']
                    },
                    {
                        id: 'dark', name: 'Dark',
                        bg: '#171717', sidebar: '#262626', border: '#404040',
                        text: '#fafafa', accent: '#e5e5e5',
                        swatches: ['#171717', '#262626', '#404040', '#fafafa']
                    },
                    {
                        id: 'system', name: 'System',
                        bg: '#f5f5f5', sidebar: '#171717', border: '#e5e5e5',
                        text: '#171717', accent: '#404040',
                        swatches: ['#f5f5f5', '#171717', '#e5e5e5', '#262626'],
                        split: true
                    },
                    {
                        id: 'midnight', name: 'Midnight',
                        bg: '#0f172a', sidebar: '#1e293b', border: '#334155',
                        text: '#f1f5f9', accent: '#3b82f6',
                        swatches: ['#0f172a', '#1e293b', '#334155', '#3b82f6']
                    },
                    {
                        id: 'ocean', name: 'Ocean',
                        bg: '#040d1a', sidebar: '#0e2040', border: '#1a3560',
                        text: '#e0eef7', accent: '#38bdf8',
                        swatches: ['#040d1a', '#0e2040', '#1a3560', '#38bdf8']
                    },
                    {
                        id: 'forest', name: 'Forest',
                        bg: '#020f05', sidebar: '#0c2812', border: '#14391c',
                        text: '#d4edda', accent: '#34d399',
                        swatches: ['#020f05', '#0c2812', '#14391c', '#34d399']
                    },
                    {
                        id: 'rose', name: 'Rose',
                        bg: '#150508', sidebar: '#36101c', border: '#501828',
                        text: '#f5ccda', accent: '#fb7185',
                        swatches: ['#150508', '#36101c', '#501828', '#fb7185']
                    },
                    {
                        id: 'sunset', name: 'Sunset',
                        bg: '#150700', sidebar: '#3a1500', border: '#552000',
                        text: '#f8d4a8', accent: '#fb923c',
                        swatches: ['#150700', '#3a1500', '#552000', '#fb923c']
                    },
                    {
                        id: 'lavender', name: 'Lavender',
                        bg: '#0a0612', sidebar: '#1e1430', border: '#2e2048',
                        text: '#e4d8f5', accent: '#c084fc',
                        swatches: ['#0a0612', '#1e1430', '#2e2048', '#c084fc']
                    },
                    {
                        id: 'custom', name: 'Custom',
                        bg: '#0a0a10', sidebar: '#1c1c28', border: '#2c2c40',
                        text: '#ededf4', accent: '#818cf8',
                        swatches: ['#0a0a10', '#1c1c28', '#2c2c40', '#818cf8'],
                        isCustom: true
                    },
                ],

                selectTheme(id) {
                    $flux.appearance = id;
                    if (id === 'custom') {
                        this.$nextTick(() => this.applyCustomColors());
                    }
                },

                applyCustomColors() {
                    const hex = this.customAccent;
                    document.documentElement.style.setProperty('--custom-accent', hex);
                    document.documentElement.style.setProperty('--custom-accent-light', this.lightenColor(hex, 35));
                    localStorage.setItem('theme-custom-accent', hex);
                    const customPreset = this.presets.find(p => p.id === 'custom');
                    if (customPreset) {
                        customPreset.accent = hex;
                        customPreset.swatches = ['#0a0a10', '#1c1c28', '#2c2c40', hex];
                    }
                },

                lightenColor(hex, amount) {
                    const num = parseInt(hex.replace('#',''), 16);
                    const r = Math.min(255, (num >> 16) + amount);
                    const g = Math.min(255, ((num >> 8) & 0x00FF) + amount);
                    const b = Math.min(255, (num & 0x0000FF) + amount);
                    return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
                },

                init() {
                    if ($flux.appearance === 'custom') {
                        this.$nextTick(() => this.applyCustomColors());
                    }
                    this.$watch('customAccent', () => {
                        if ($flux.appearance === 'custom') {
                            this.applyCustomColors();
                        } else {
                            const customPreset = this.presets.find(p => p.id === 'custom');
                            if (customPreset) {
                                customPreset.accent = this.customAccent;
                                customPreset.swatches = ['#0a0a10', '#1c1c28', '#2c2c40', this.customAccent];
                            }
                        }
                    });
                }
            }"
            class="space-y-8"
        >

            {{-- ── Section label ── --}}
            <div>
                <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 mb-0.5">Theme Presets</p>
                <p class="text-xs text-zinc-500">Click a card to instantly switch your workspace theme</p>
            </div>

            {{-- ── Theme Grid ── --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3">
                <template x-for="preset in presets" :key="preset.id">
                    <button
                        @click="selectTheme(preset.id)"
                        :class="$flux.appearance === preset.id
                            ? 'ring-2 ring-accent ring-offset-2 ring-offset-white dark:ring-offset-zinc-900 shadow-xl scale-[1.03]'
                            : 'ring-1 ring-zinc-200 dark:ring-zinc-700 hover:shadow-md hover:scale-[1.01] hover:ring-zinc-300 dark:hover:ring-zinc-500'"
                        class="relative group rounded-2xl overflow-hidden text-left transition-all duration-200 cursor-pointer focus:outline-none"
                    >

                        {{-- Mini UI preview --}}
                        <div
                            class="h-[88px] relative flex overflow-hidden"
                            :style="`background: ${preset.bg}`"
                        >
                            {{-- Special split for System theme --}}
                            <template x-if="preset.split">
                                {{-- Left half: light --}}
                                <div class="flex flex-1">
                                    <div class="w-7 h-full flex flex-col gap-1 p-1 flex-shrink-0" style="background:#f5f5f5">
                                        <div class="w-full h-1.5 rounded-sm" style="background:#e5e5e5"></div>
                                        <div class="w-3/4 h-1 rounded-sm" style="background:#e5e5e5"></div>
                                        <div class="w-3/4 h-1 rounded-sm" style="background:#e5e5e5"></div>
                                        <div class="mt-auto w-full h-1.5 rounded-sm" style="background:#404040"></div>
                                    </div>
                                    <div class="w-1/2 flex-1 p-1.5 flex flex-col gap-1" style="background:#ffffff">
                                        <div class="h-1.5 rounded-full w-full" style="background:#e5e5e5"></div>
                                        <div class="h-1 rounded-full w-3/4" style="background:#e5e5e5;opacity:.6"></div>
                                        <div class="h-1 rounded-full w-1/2" style="background:#e5e5e5;opacity:.4"></div>
                                        <div class="mt-auto h-3.5 rounded w-10" style="background:#404040"></div>
                                    </div>
                                </div>
                                {{-- Right half: dark --}}
                                <div class="flex flex-1" style="border-left:1px solid #555">
                                    <div class="w-7 h-full flex flex-col gap-1 p-1 flex-shrink-0" style="background:#262626">
                                        <div class="w-full h-1.5 rounded-sm" style="background:#404040"></div>
                                        <div class="w-3/4 h-1 rounded-sm" style="background:#404040"></div>
                                        <div class="w-3/4 h-1 rounded-sm" style="background:#404040"></div>
                                        <div class="mt-auto w-full h-1.5 rounded-sm" style="background:#fafafa"></div>
                                    </div>
                                    <div class="flex-1 p-1.5 flex flex-col gap-1" style="background:#171717">
                                        <div class="h-1.5 rounded-full w-full" style="background:#404040"></div>
                                        <div class="h-1 rounded-full w-3/4" style="background:#404040;opacity:.6"></div>
                                        <div class="h-1 rounded-full w-1/2" style="background:#404040;opacity:.4"></div>
                                        <div class="mt-auto h-3.5 rounded w-10" style="background:#fafafa"></div>
                                    </div>
                                </div>
                            </template>

                            {{-- Normal theme preview --}}
                            <template x-if="!preset.split">
                                <div class="flex w-full">
                                    {{-- Sidebar --}}
                                    <div
                                        class="w-8 h-full flex flex-col gap-1 p-1 flex-shrink-0"
                                        :style="`background: ${preset.sidebar}`"
                                    >
                                        <div class="w-full h-1.5 rounded-sm" :style="`background: ${preset.text}; opacity:.55`"></div>
                                        <div class="w-3/4 h-1 rounded-sm"   :style="`background: ${preset.text}; opacity:.35`"></div>
                                        <div class="w-3/4 h-1 rounded-sm"   :style="`background: ${preset.text}; opacity:.35`"></div>
                                        <div class="w-3/4 h-1 rounded-sm"   :style="`background: ${preset.text}; opacity:.35`"></div>
                                        <div class="mt-auto w-full h-1.5 rounded-sm" :style="`background: ${preset.accent}`"></div>
                                    </div>
                                    {{-- Content --}}
                                    <div class="flex-1 p-2 flex flex-col gap-1.5">
                                        <div class="flex gap-1 items-center">
                                            <div class="h-2 rounded-full flex-1"  :style="`background: ${preset.border}`"></div>
                                            <div class="h-2 w-2 rounded-full"    :style="`background: ${preset.border}`"></div>
                                        </div>
                                        <div class="h-1.5 rounded-full w-full"  :style="`background: ${preset.border}; opacity:.7`"></div>
                                        <div class="h-1.5 rounded-full w-3/4"   :style="`background: ${preset.border}; opacity:.5`"></div>
                                        <div class="h-1.5 rounded-full w-1/2"   :style="`background: ${preset.border}; opacity:.4`"></div>
                                        <div class="mt-auto">
                                            <div class="h-4 rounded-md w-14" :style="`background: ${preset.accent}`"></div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            {{-- Selected checkmark --}}
                            <div
                                x-show="$flux.appearance === preset.id"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-50"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full flex items-center justify-center shadow-md"
                                :style="`background: ${preset.accent}`"
                            >
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Name + color swatches --}}
                        <div
                            class="flex items-center justify-between px-2.5 py-2 border-t"
                            :style="`background: ${preset.sidebar}; border-color: ${preset.border}`"
                        >
                            <span
                                class="text-[11px] font-semibold tracking-wide uppercase"
                                :style="`color: ${preset.text}`"
                                x-text="preset.name"
                            ></span>
                            <div class="flex gap-0.5 items-center">
                                <template x-for="(sw, i) in (preset.isCustom ? ['#0a0a10','#1c1c28','#2c2c40', customAccent] : preset.swatches)">
                                    <div
                                        class="w-2.5 h-2.5 rounded-full"
                                        style="border: 1px solid rgba(255,255,255,0.15)"
                                        :style="`background: ${sw}`"
                                    ></div>
                                </template>
                            </div>
                        </div>
                    </button>
                </template>
            </div>

            {{-- ── Custom Theme Color Picker ── --}}
            <div
                x-show="$flux.appearance === 'custom'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="rounded-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden"
            >
                {{-- Header --}}
                <div class="bg-gradient-to-r from-zinc-100 to-zinc-50 dark:from-zinc-800 dark:to-zinc-800/60 px-5 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">🎨</span>
                        <div>
                            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Custom Theme</p>
                            <p class="text-xs text-zinc-500 mt-0.5">Choose your accent color — the dark base adapts around it</p>
                        </div>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-5 bg-white dark:bg-zinc-900/40">
                    <div class="flex flex-col sm:flex-row gap-6 items-start">

                        {{-- Left: Controls --}}
                        <div class="flex-1 space-y-4">
                            <div>
                                <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wide block mb-3">
                                    Accent Color
                                </label>

                                {{-- Color picker + hex input --}}
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="relative">
                                        <input
                                            type="color"
                                            x-model="customAccent"
                                            class="w-11 h-11 rounded-xl cursor-pointer border-2 border-zinc-200 dark:border-zinc-600 p-0.5 bg-transparent appearance-none"
                                        >
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-zinc-500 mb-1">Hex</span>
                                        <input
                                            type="text"
                                            x-model="customAccent"
                                            maxlength="7"
                                            placeholder="#818cf8"
                                            class="w-24 text-xs font-mono px-2 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-accent"
                                        >
                                    </div>
                                    <div class="h-9 w-9 rounded-xl shadow-inner flex-shrink-0" :style="`background: ${customAccent}`"></div>
                                </div>

                                {{-- Quick-pick swatches --}}
                                <div>
                                    <span class="text-xs text-zinc-500 block mb-2">Quick picks</span>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="color in ['#818cf8','#6366f1','#34d399','#22d3ee','#38bdf8','#fb7185','#fb923c','#facc15','#f472b6','#c084fc','#a3e635','#f87171']">
                                            <button
                                                @click="customAccent = color"
                                                :title="color"
                                                :class="customAccent === color ? 'ring-2 ring-offset-2 ring-zinc-400 dark:ring-zinc-500 scale-110' : 'hover:scale-110'"
                                                class="w-7 h-7 rounded-full transition-all duration-150 focus:outline-none shadow-sm"
                                                :style="`background: ${color}`"
                                            ></button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Live Preview --}}
                        <div class="flex-shrink-0">
                            <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wide block mb-3">Preview</span>
                            <div class="w-44 rounded-xl overflow-hidden shadow-lg border border-zinc-200 dark:border-zinc-700">
                                {{-- Preview header --}}
                                <div class="h-5 flex items-center gap-1 px-2" style="background:#101018">
                                    <div class="w-2 h-2 rounded-full" style="background:#3a3a50"></div>
                                    <div class="flex-1 h-1 rounded-full" style="background:#2c2c40"></div>
                                    <div class="w-2 h-2 rounded-full" :style="`background: ${customAccent}`"></div>
                                </div>
                                {{-- Preview body --}}
                                <div class="h-24 flex" style="background:#0a0a10">
                                    <div class="w-10 h-full flex flex-col gap-1 p-1.5" style="background:#1c1c28">
                                        <div class="w-full h-1.5 rounded-sm" style="background:#ededf4;opacity:.55"></div>
                                        <div class="w-3/4 h-1 rounded-sm"   style="background:#ededf4;opacity:.35"></div>
                                        <div class="w-3/4 h-1 rounded-sm"   style="background:#ededf4;opacity:.35"></div>
                                        <div class="w-3/4 h-1 rounded-sm"   style="background:#ededf4;opacity:.35"></div>
                                        <div class="mt-auto w-full h-2 rounded-sm" :style="`background: ${customAccent}`"></div>
                                    </div>
                                    <div class="flex-1 p-2 flex flex-col gap-1.5">
                                        <div class="h-2 rounded-full w-full"  style="background:#2c2c40"></div>
                                        <div class="h-1.5 rounded-full w-3/4" style="background:#2c2c40;opacity:.7"></div>
                                        <div class="h-1.5 rounded-full w-1/2" style="background:#2c2c40;opacity:.5"></div>
                                        <div class="mt-auto">
                                            <div class="h-5 rounded-md w-16 flex items-center justify-center" :style="`background: ${customAccent}`">
                                                <div class="h-1 rounded-full w-8" style="background:rgba(255,255,255,0.7)"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Preview footer --}}
                                <div class="px-3 py-1.5 flex items-center justify-between" style="background:#1c1c28;border-top:1px solid #2c2c40">
                                    <span class="text-[10px] font-semibold" style="color:#ededf4">Custom</span>
                                    <div class="w-3 h-3 rounded-full" :style="`background: ${customAccent}`"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </x-settings.layout>
</section>