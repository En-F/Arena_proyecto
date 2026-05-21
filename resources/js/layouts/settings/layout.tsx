import { Link } from '@inertiajs/react';
import type { PropsWithChildren } from 'react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useCurrentUrl } from '@/hooks/use-current-url';
import { cn, toUrl } from '@/lib/utils';
import { edit } from '@/routes/profile';
import { edit as editSecurity } from '@/routes/security';
import type { NavItem } from '@/types';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Perfil',
        href: edit(),
        icon: null,
    },
    {
        title: 'Seguridad',
        href: editSecurity(),
        icon: null,
    },
    {
        title: 'Historial de reservas',
        href: '/Historia/show',
        icon: null,
    },
    {
        title: 'Generación QR',
        href: '/settings/UserQr',
        icon: null,
    },
];

export default function SettingsLayout({ children }: PropsWithChildren) {
    const { isCurrentOrParentUrl } = useCurrentUrl();

    return (
        <>
            <div className="mx-auto w-full max-w-5xl px-4 py-6">
                <Heading
                    title="Perfil Personal"
                    description="Gestiona tu perfil y la configuración de tu cuenta."
                />

                <div className="mt-8 flex flex-col lg:flex-row lg:space-x-12">
                    <aside className="w-full flex-shrink-0 lg:w-48">
                        <nav
                            className="flex flex-col space-y-1 space-x-0"
                            aria-label="Settings"
                        >
                            {sidebarNavItems.map((item, index) => {
                                const isActive = isCurrentOrParentUrl(
                                    item.href,
                                );

                                return (
                                    <Button
                                        key={`${toUrl(item.href)}-${index}`}
                                        size="sm"
                                        variant={isActive ? 'default' : 'ghost'}
                                        asChild
                                        className={cn(
                                            'w-full justify-start text-left font-normal',
                                            isActive &&
                                                'bg-[#0070f3] font-medium text-sidebar-foreground',
                                        )}
                                    >
                                        <Link href={item.href}>
                                            {item.icon && (
                                                <item.icon className="h-4 w-4" />
                                            )}
                                            {item.title}
                                        </Link>
                                    </Button>
                                );
                            })}
                        </nav>
                    </aside>

                    <Separator className="my-6 lg:hidden" />

                    <div className="flex-1">
                        <section className="space-y-12">{children}</section>
                    </div>
                </div>
            </div>
        </>
    );
}
