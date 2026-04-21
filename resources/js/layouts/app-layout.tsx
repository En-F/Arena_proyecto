import AppLayoutTemplate from '@/layouts/app/app-sidebar-layout';
import type { BreadcrumbItem } from '@/types';
import Navbar from '@/components/Layouts/Navbar';
import Footer from '@/components/Layouts/Footer';
import CookieConsent from '@/components/cooki/CookieConsent';

export default function AppLayout({
    breadcrumbs = [],
    children,
}: {
    breadcrumbs?: BreadcrumbItem[];
    children: React.ReactNode;
}) {
    return (
        <AppLayoutTemplate breadcrumbs={breadcrumbs}>
            <div className="flex min-h-screen flex-col">
                <Navbar />

                <main className="flex-1">{children}</main>
                <main className="flex-1">{children}
                    <CookieConsent />
                </main>

                <Footer />
            </div>
        </AppLayoutTemplate>
    );
}
