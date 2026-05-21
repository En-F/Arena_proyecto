import React from 'react';
import { Link } from '@inertiajs/react';

export default function SobreNosotros() {
    return (
        <>
            <div className="bg-gray-50 py-12 lg:py-24">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="mb-12 text-center lg:mb-20">
                        <h1 className="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl md:text-5xl lg:text-6xl">
                            Sobre{' '}
                            <span className="text-blue-600">Nosotros</span>
                        </h1>
                    </div>

                    <div className="mb-20 grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-16">
                        <div className="order-2 lg:order-1">
                            <h2 className="mb-4 text-2xl font-bold text-gray-800 md:text-3xl">
                                Nuestra Historia
                            </h2>
                            <p className="mb-4 leading-relaxed text-gray-600 md:text-lg">
                                Nacimos con la idea de simplificar los procesos
                                administrativos de los centros, permitiendo que
                                tanto administradores como usuarios finales
                                disfruten de una experiencia fluida y
                                tecnológica.
                            </p>
                            <p className="leading-relaxed text-gray-600 md:text-lg">
                                Hoy en día, ayudamos a cientos de personas a
                                gestionar sus suscripciones y reservas de forma
                                segura mediante herramientas modernas como
                                códigos QR y notificaciones inteligentes.
                            </p>
                        </div>
                        <div className="order-1 mt-10 lg:order-2 lg:mt-0 lg:ml-16">
                            <img
                                className="mt-14px h-full w-full object-cover transition-transform duration-500 hover:scale-105"
                                src="/storage/otros/nosotros.jpg"
                                alt="Nuestro equipo trabajando en soluciones tecnológicas"
                            />
                        </div>
                    </div>

                    <div className="mb-20 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <div className="rounded-2xl bg-white p-8 shadow-sm transition-shadow hover:shadow-md">
                            <div className="mb-4 inline-block rounded-lg bg-blue-50 p-3 text-3xl">
                                🚀
                            </div>
                            <h3 className="mb-2 text-xl font-bold text-gray-900">
                                Rapidez
                            </h3>
                            <p className="text-gray-600">
                                Gestiones en segundos desde cualquier
                                dispositivo, optimizando tu tiempo al máximo.
                            </p>
                        </div>
                        <div className="rounded-2xl bg-white p-8 shadow-sm transition-shadow hover:shadow-md">
                            <div className="mb-4 inline-block rounded-lg bg-blue-50 p-3 text-3xl">
                                🛡️
                            </div>
                            <h3 className="mb-2 text-xl font-bold text-gray-900">
                                Seguridad
                            </h3>
                            <p className="text-gray-600">
                                Encriptación de nivel bancario. Tus datos y los
                                de tus clientes están siempre a salvo.
                            </p>
                        </div>
                        <div className="rounded-2xl bg-white p-8 shadow-sm transition-shadow hover:shadow-md sm:col-span-2 lg:col-span-1">
                            <div className="mb-4 inline-block rounded-lg bg-blue-50 p-3 text-3xl">
                                🤝
                            </div>
                            <h3 className="mb-2 text-xl font-bold text-gray-900">
                                Cercanía
                            </h3>
                            <p className="text-gray-600">
                                No somos solo software; somos tu socio
                                tecnológico con atención humana 24/7.
                            </p>
                        </div>
                    </div>

                    <div className="relative overflow-hidden rounded-3xl bg-blue-600 px-6 py-12 text-center text-white shadow-2xl md:px-12 md:py-20">
                        <div className="absolute -top-20 -right-20 h-64 w-64 rounded-full bg-blue-500 opacity-20"></div>
                        <div className="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-blue-700 opacity-20"></div>

                        <div className="relative z-10">
                            <h2 className="mb-4 text-3xl font-bold md:text-4xl">
                                ¿Tienes alguna pregunta?
                            </h2>
                            <p className="mx-auto mb-10 max-w-xl text-lg text-blue-100">
                                Nuestro equipo de soporte está listo para
                                ayudarte a llevar tu centro al siguiente nivel.
                            </p>
                            <Link
                                href={route('contacto.inicio')}
                                className="inline-block rounded-xl bg-white px-8 py-4 text-lg font-bold text-blue-600 transition-all hover:bg-gray-100 hover:shadow-lg sm:w-auto"
                            >
                                Contactar ahora
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
