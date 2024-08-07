import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createI18n } from 'vue-i18n'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import { driver } from "driver.js"
import "driver.js/dist/driver.css"
import {install} from '@github/hotkey'
import * as Sentry from "@sentry/vue";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const locales = props.initialPage.props.locales
        let locale = Object.keys(locales).includes(navigator.language) ? navigator.language : 'en'

        if (localStorage.getItem('locale')) {
            locale = localStorage.getItem('locale')
        } else {
            localStorage.setItem('locale', locale)
        }

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(createI18n({
                locale: props.initialPage.props.auth?.user?.locale
                    ?? locale
                    ?? props.initialPage.props.appLocale,
                fallbackLocale: props.initialPage.props.appLocale,
                messages: props.initialPage.props.localeMessages,
            }))
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
  });

const driverInstance = driver();

for (const element of document.querySelectorAll('[data-hotkey]')) {
  install(element);
}
