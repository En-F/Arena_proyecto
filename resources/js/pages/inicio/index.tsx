import { Head, Link } from '@inertiajs/react';
import React from 'react';
import '../../../css/inicio.css';
import AppLayout from '@/layouts/app-layout';
import CartaActividad from '@/components/CartaActividad';
import CartaNoticia from '@/components/CartaNoticia';
import MainLayout from '@/Layouts/MainLayout';
import Footer from '@/components/Layouts/Footer';
import Navbar from '@/components/Layouts/Navbar';

interface Props {
    centros: any[];
    noticias: any[];
    actividades: any[];
}

export default function Inicio({ centros, noticias, actividades }: Props) {
    const breadcrumbs = [{ title: 'Inicio', href: '/inicio' }];
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Arena" />

            <div className="relative flex flex-1 flex-col overflow-hidden rounded-xl border border-sidebar-border/70 bg-white shadow-sm">
                <header className="sticky top-0 z-30 w-full border-b border-gray-100 bg-white">
                    <Navbar />
                </header>

                <div className="flex-1 space-y-12 overflow-y-auto p-6">
                    <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                        {/* {centros.slice(0, 3).map((centro) => (
                            <div
                                key={centro.id}
                                className="relative flex aspect-video items-center justify-center overflow-hidden rounded-xl border border-sidebar-border/70 bg-white p-4 shadow-sm"
                            >
                                <Link
                                    href={`/centros/${centro.id}`}
                                    className="group text-center"
                                >
                                    <div className="mx-auto mb-1 h-14 w-14 overflow-hidden rounded-full border-2 border-[#66ff66]">
                                        <img
                                            src={
                                                centro.imagen ||
                                                '/images/centros/atletismo.jpg'
                                            }
                                            className="h-full w-full object-cover"
                                        />
                                    </div>
                                    <p className="text-[10px] font-bold text-gray-800 uppercase">
                                        {centro.nombre}
                                    </p>
                                </Link>
                            </div>
                        ))} */}
                    </div>
                    {/* Noticias */}
                    <section className="section-noticias !m-0">
                        <h2 className="title-black !m-0 !mb-6 !text-left !text-2xl !text-gray-900">
                            Noticias
                        </h2>
                        <div className="noticia-container !m-0 border border-slate-100 !bg-slate-50 shadow-inner">
                            <div className="grid w-full grid-cols-1 gap-4 p-2 md:grid-cols-3">
                                {/* {noticias.map((noticia) => (
                                    <CartaNoticia
                                        key={noticia.id}
                                        date={new Date(
                                            noticia.created_at,
                                        ).toLocaleDateString()}
                                        text={noticia.titulo}
                                    />
                                ))} */}
                            </div>
                        </div>
                    </section>

                    {/* Banner CTA */}
                    <section className="banner-cta !p-0">
                        <div className="banner-content !m-0 !w-full border border-slate-200 !shadow-none">
                            <div className="banner-image">
                                <img
                                    src="/images/entrenador/entrenador.jpg"
                                    alt="Entrenador"
                                />
                            </div>
                            <div className="banner-text-box !p-8">
                                <h3 className="!text-2xl font-bold">
                                    Inscríbete ahora
                                </h3>
                                <p className="!mt-2">Empieza hoy tu cambio.</p>
                                <button className="btn-inscripcion !mt-6">
                                    ¡Inscríbete!
                                </button>
                            </div>
                        </div>
                    </section>

                    {/* Actividades */}
                    <section className="section-actividades !p-0 pb-10">
                        <h2 className="title-black !m-0 !mb-6 !text-left !text-2xl !text-gray-900">
                            Actividades
                        </h2>
                        <div className="activities-grid !w-full !justify-start !gap-4">
                            {/* {actividades.map((act) => (
                                <CartaActividad
                                    key={act.id}
                                    title={act.nombre}
                                    imagen={
                                        act.imagen ||
                                        '/images/actividades/ciclismo.jpg'
                                    }
                                />
                            ))} */}
                        </div>
                    </section>
                </div>
                <div className="border-t border-gray-100">
                    <Footer />
                </div>
            </div>
        </AppLayout>
    );
}

Inicio.layout = (page: React.ReactNode) => <MainLayout children={page} />;
