
// CommonJS Vite config that dynamically imports ESM-only plugins.
const { defineConfig } = require('vite');
const laravelRaw = require('laravel-vite-plugin');
const laravel = laravelRaw && laravelRaw.default ? laravelRaw.default : laravelRaw;

module.exports = async () => {
    const { viteStaticCopy } = await import('vite-plugin-static-copy');

    return defineConfig({
        build: {
            manifest: true,
            rtl: true,
            outDir: 'public/build/',
            cssCodeSplit: true,
            rollupOptions: {
                output: {
                    assetFileNames: (assetInfo) => {
                        const name = assetInfo.name || '';
                        if (name.endsWith('.css')) {
                            return `css/[name].min.css`;
                        }
                        return `icons/${name || '[name]'}`;
                    },
                    entryFileNames: `js/[name].js`,
                },
            },
        },
        plugins: [
            laravel({
                input: [
                    'resources/scss/bootstrap.scss',
                    'resources/scss/icons.scss',
                    'resources/scss/app.scss',
                ],
                refresh: true,
            }),
            viteStaticCopy({
                targets: [
                    { src: 'resources/fonts', dest: '' },
                    { src: 'resources/images', dest: '' },
                    { src: 'resources/js', dest: '' },
                    { src: 'resources/json', dest: '' },
                    { src: 'resources/libs', dest: '' },
                ],
            }),
        ],
    });
};