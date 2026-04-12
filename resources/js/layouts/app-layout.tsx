import AppLayoutTemplate from '@/layouts/app/app-sidebar-layout';
import type { BreadcrumbItem } from '@/types';
import Navbar from '@/components/Layouts/Navbar';
import Footer from '@/components/Layouts/Footer';

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

                <main className="flex-1">
                    {children} {/* Aquí se cargará Inicio, Dashboard, etc. */}
                </main>

                <Footer />
            </div>
        </AppLayoutTemplate>
    );
}
