import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    experimental: {
        renderBuiltUrl(filename, { hostType }) {
            if (hostType === 'css') {
                return { relative: true };
            }
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        {
            name: 'prepend-charset',
            generateBundle(options, bundle) {
                for (const fileName in bundle) {
                    if (fileName.endsWith('.css')) {
                        const original = bundle[fileName].source;
                        // Avoid prepending if it's already there
                        if (typeof original === 'string' && !original.startsWith('@charset')) {
                            bundle[fileName].source = '@charset "UTF-8";\n' + original;
                        }
                    }
                }
            }
        }
    ],
});
