import '../css/app.css';
import './bootstrap';
import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue');

        const exactPath = `./Pages/${name}.vue`;
        if (pages[exactPath]) {
            return await pages[exactPath]();
        }

        const indexPath = `./Pages/${name}/Index.vue`;
        if (pages[indexPath]) {
            return await pages[indexPath]();
        }

        throw new Error(`Page not found: ${name}`);
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
