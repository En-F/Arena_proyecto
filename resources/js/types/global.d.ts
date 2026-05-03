import type { Auth } from '@/types/auth';
import { route as ziggyRoute } from 'ziggy-js';

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string;
            auth: Auth;
            sidebarOpen: boolean;
            [key: string]: unknown;
        };
    }
}

declare global {
    var route: typeof ziggyRoute;
}
