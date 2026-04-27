import { Head } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import '../../../css/inicio.css';
import CartaNoticia from '@/components/carta/CartaNoticia';
import BannerInscripcion from '../../components/banner/BannerInscripcion';
import CartaActividad from '../../components/carta/CartaActividad';
import CartaCentro from '../../components/carta/CartaCentro';

interface Props {
    centros: any[];
    noticias: any[];
    actividades: any[];
}

export default function Inicio({
    centros,
    noticias,
    actividades,
}: Props) {
    const esCarrusel = actividades.length > 7;
    
    const { auth } = usePage().props as any;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    return (
        <>
            <Head title="Inicio " />
            <div className="main-container">
                {/* --- SECCIÓN CENTROS --- */}
                <section className="section-centros">
                    <h2 className="title-black">Nuestros Centros</h2>

                    <div className="grid-centros">
                        {centros.slice(0, 4).map((centro) => (
                            <CartaCentro
                                key={centro.id}
                                id={centro.id}
                                nombre={centro.nombre}
                                imagen={centro.imagen}
                            />
                        ))}
                        {is_admin  && <CartaActividad esCrear />}
                    </div>
                </section>

                {/* --- SECCIÓN INSCRIPCIÓN --- */}
                <section className="banner-cta">
                    <BannerInscripcion
                        imagen="inscripcion.jpg"
                        titulo="¡Inscríbete Ahora!"
                        descripcion="Únete a nuestras actividades deportivas y disfruta de una experiencia única."
                        textBoton="Haz tu Inscripción"
                        href="/register"
                    />
                </section>

                {/* --- SECCIÓN ACTIVIDADES --- */}
                <section className="section-actividades">
                    <h2 className="title-black text-white">
                        Actividades Deportivas
                    </h2>
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
                            {(is_admin || is_jefe) && <CartaActividad esCrear />}
                        </div>
                    )}
                </section>

                {/* --- SECCIÓN NOTICIAS --- */}
                <section className="section-noticias pb-20">
                    <h2 className="title-black">Últimas Noticias</h2>
                    <div className="noticia-container">
                        {noticias.slice(0, 4).map((noticia) => (
                            <CartaNoticia
                                key={noticia.id}
                                id={noticia.id}
                                titulo={noticia.titulo}
                                imagen={noticia.imagen}
                                contenido={noticia.contenido}
                                esCrear={false}
                            />
                        ))}
                       {(is_admin || is_jefe) && <CartaActividad esCrear />}
                    </div>
                </section>
            </div>
        </>
    );
}
