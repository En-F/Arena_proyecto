<<<<<<< HEAD
import { Head, Link } from '@inertiajs/react';
import '../../../css/inicio.css';
import CartaNoticia from '@/components/carta/CartaNoticia';
import CartaCentro from '@/components/carta/CartaCentro';
import CartaActividad from '@/components/carta/CartaActividad';
import BannerInscripcion from '@/components/banner/BannerInscripcion';
=======
import { Head } from '@inertiajs/react';
import '../../../css/inicio.css';
import CartaNoticia from '@/components/carta/CartaNoticia';
import BannerInscripcion from '../../components/banner/BannerInscripcion';
import CartaActividad from '../../components/carta/CartaActividad';
import CartaCentro from '../../components/carta/CartaCentro';
>>>>>>> fb55ae0 (Intregración de las cookies)

interface Props {
    centros: any[];
    noticias: any[];
    actividades: any[];
<<<<<<< HEAD
}

export default function Inicio({ centros, noticias, actividades }: Props) {
=======
    esAdmin?: boolean;
}

export default function Inicio({
    centros,
    noticias,
    actividades,
    esAdmin,
}: Props) {
    console.log(esAdmin);
    const esCarrusel = actividades.length > 7;

>>>>>>> fb55ae0 (Intregración de las cookies)
    return (
        <>
            <Head title="Inicio " />
            <div className="main-container">
                {/* --- SECCIÓN CENTROS --- */}
                <section className="section-centros">
                    <h2 className="title-black">Nuestros Centros</h2>

                    <div className="grid-centros">
<<<<<<< HEAD
                        {centros.slice(0, 3).map((centro) => (
                            <CartaCentro
=======
                        {centros.slice(0, 4).map((centro) => (
                            <CartaCentro
                                key={centro.id}
>>>>>>> fb55ae0 (Intregración de las cookies)
                                id={centro.id}
                                nombre={centro.nombre}
                                imagen={centro.imagen}
                            />
                        ))}
<<<<<<< HEAD
                    </div>
                </section>

                {/* --- SECCIÓN INSCRIPCIÓN (BANNER CTA) --- */}
=======
                        {esAdmin && <CartaCentro esCrear />}
                    </div>
                </section>

                {/* --- SECCIÓN INSCRIPCIÓN --- */}
>>>>>>> fb55ae0 (Intregración de las cookies)
                <section className="banner-cta">
                    <BannerInscripcion
                        imagen="inscripcion.jpg"
                        titulo="¡Inscríbete Ahora!"
                        descripcion="Únete a nuestras actividades deportivas y disfruta de una experiencia única."
                        textBoton="Haz tu Inscripción"
<<<<<<< HEAD
                        href="/actividades"
=======
                        href="/register"
>>>>>>> fb55ae0 (Intregración de las cookies)
                    />
                </section>

                {/* --- SECCIÓN ACTIVIDADES --- */}
                <section className="section-actividades">
                    <h2 className="title-black text-white">
                        Actividades Deportivas
                    </h2>
<<<<<<< HEAD
                    <div className="activities-grid">
                        {actividades.slice(0, 3).map((actividad) => (
                            <CartaActividad
                                id={actividad.id}
                                titulo={actividad.titulo}
                                imagen={actividad.imagen}
                            />
                        ))}
                    </div>
=======
                    {esCarrusel ? (
                        <div className="carrusel-track">
                            {[...actividades, ...actividades].map(
                                (actividad, index) => (
                                    <div className="carrusel-item" key={index}>
                                        <CartaActividad
                                            id={actividad.id}
                                            titulo={actividad.titulo}
                                            imagen={actividad.imagen}
                                        />
                                    </div>
                                ),
                            )}
                        </div>
                    ) : (
                        <div className="activities-grid">
                            {actividades.slice(0, 4).map((actividad) => (
                                <CartaActividad
                                    key={actividad.id}
                                    id={actividad.id}
                                    titulo={actividad.titulo}
                                    imagen={actividad.imagen}
                                    esCrear={false}
                                />
                            ))}
                            {esAdmin && <CartaActividad esCrear />}
                        </div>
                    )}
>>>>>>> fb55ae0 (Intregración de las cookies)
                </section>

                {/* --- SECCIÓN NOTICIAS --- */}
                <section className="section-noticias pb-20">
                    <h2 className="title-black">Últimas Noticias</h2>
                    <div className="noticia-container">
                        {noticias.slice(0, 4).map((noticia) => (
                            <CartaNoticia
<<<<<<< HEAD
=======
                                key={noticia.id}
>>>>>>> fb55ae0 (Intregración de las cookies)
                                id={noticia.id}
                                titulo={noticia.titulo}
                                imagen={noticia.imagen}
                                contenido={noticia.contenido}
<<<<<<< HEAD
                            />
                        ))}
=======
                                esCrear={false}
                            />
                        ))}
                        {esAdmin && <CartaNoticia esCrear />}
>>>>>>> fb55ae0 (Intregración de las cookies)
                    </div>
                </section>
            </div>
        </>
    );
}
