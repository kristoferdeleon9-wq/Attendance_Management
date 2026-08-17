import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/attendance-scanner.css',
                'resources/css/attendance-session.css',
                'resources/css/attendance.css',
                'resources/css/class-create.css',
                'resources/css/class-show.css',
                'resources/css/classes.css',
                'resources/css/dashboard.css',
                'resources/css/login.css',
                'resources/css/reports.css',
                'resources/css/sections.css',
                'resources/css/student-create.css',
                'resources/css/student-qr.css',
                'resources/css/students.css',
                'resources/css/teacher.css',
                'resources/css/settings.css',
                'resources/css/main.css',
                "resources/css/student-access.css",
                "resources/css/student-register.css",
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
