import { defineConfig } from 'vite'; 
import laravel from 'laravel-vite-plugin'; 
import vue from '@vitejs/plugin-vue'; 
 
export default defineConfig({ 
    plugins: [ 
        laravel({ 
            input: 'resources/js/app.js', 
            refresh: true, 
        }), 
        vue({ 
            template: { 
                transformAssetUrls: { 
                    base: null, 
                    includeAbsolute: false, 
                }, 
            }, 
        }), 
    ], 
    server: { 
        origin: 'https://gdpr-checklist-app.onrender.com' 
    }, 
    preview: { 
        allowedHosts: ['gdpr-checklist-app.onrender.com'] 
    } 
}); 
