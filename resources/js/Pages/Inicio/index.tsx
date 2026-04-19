import { Head, Link } from '@inertiajs/react';
import '../../../css/inicio.css';
import CartaNoticia from '@/components/carta/CartaNoticia';
import CartaCentro from '@/components/carta/CartaCentro';
import CartaActividad from '@/components/carta/CartaActividad';
import BannerInscripcion from '@/components/banner/BannerInscripcion';

interface Props {
    centros: any[];
    noticias: any[];
    actividades: any[];
}

export default function Inicio({ centros, noticias, actividades }: Props) {
    return (
        <>
            <Head title="Inicio " />
            <div className="main-container">
                {/* --- SECCIÓN CENTROS --- */}
                <section className="section-centros">
                    <h2 className="title-black">Nuestros Centros</h2>

                    <div className="grid-centros">
                        {centros.slice(0, 3).map((centro) => (
                            <CartaCentro
                                id={centro.id}
                                nombre={centro.nombre}
                                imagen={centro.imagen}
                            />
                        ))}
                    </div>
                </section>

                {/* --- SECCIÓN INSCRIPCIÓN (BANNER CTA) --- */}
                <section className="banner-cta">
                    <BannerInscripcion
                        imagen="inscripcion.jpg"
                        titulo="¡Inscríbete Ahora!"
                        descripcion="Únete a nuestras actividades deportivas y disfruta de una experiencia única."
                        textBoton="Haz tu Inscripción"
                        href="/actividades"
                    />
                </section>

                {/* --- SECCIÓN ACTIVIDADES --- */}
                <section className="section-actividades">
                    <h2 className="title-black text-white">
                        Actividades Deportivas
                    </h2>
                    <div className="activities-grid">
                        {actividades.slice(0, 3).map((actividad) => (
                            <CartaActividad
                                id={actividad.id}
                                titulo={actividad.titulo}
                                imagen={actividad.imagen}
                            />
                        ))}
                    </div>
                </section>

                {/* --- SECCIÓN NOTICIAS --- */}
                <section className="section-noticias pb-20">
                    <h2 className="title-black">Últimas Noticias</h2>
                    <div className="noticia-container">
                        {noticias.slice(0, 4).map((noticia) => (
                            <CartaNoticia
                                id={noticia.id}
                                titulo={noticia.titulo}
                                imagen={noticia.imagen}
                                contenido={noticia.contenido}
                            />
                        ))}
                    </div>
                </section>
            </div>
        </>
    );
}
