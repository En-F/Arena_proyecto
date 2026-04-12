import { Head, Link } from '@inertiajs/react';
import '../../../css/inicio.css';

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
                        {centros.map((centro) => (
                            <Link
                                key={centro.id}
                                href={`/centros/${centro.id}`}
                                className="img-card-circle"
                            >
                                <img
                                    src={`/images/centros/${centro.id}.jpg`}
                                    alt={centro.nombre}
                                />
                            </Link>
                        ))}
                    </div>
                </section>

                {/* --- SECCIÓN INSCRIPCIÓN (BANNER CTA) --- */}
                <section className="banner-cta">
                    <div className="banner-content">
                        <div className="banner-image">
                            <img
                                src="/images/otros/inscripcion.jpg"
                                alt="Inscripción"
                            />
                        </div>
                        <div className="banner-text-box">
                            <h3>TRANSFORMA TU CUERPO </h3>
                            <p>
                                Únete a la comunidad deportiva más grande y
                                alcanza tus metas con nosotros disfrutando del
                                proceso.
                            </p>
                            <button className="btn-inscripcion">
                                HAZTE SOCIO AHORA
                            </button>
                        </div>
                    </div>
                </section>

                {/* --- SECCIÓN ACTIVIDADES --- */}
                <section className="section-actividades">
                    <h2 className="title-black text-white">
                        Actividades Deportivas
                    </h2>
                    <div className="activities-grid">
                        {actividades.map((actividad) => (
                            <Link
                                key={actividad.id}
                                href={`/actividades/${actividad.id}`}
                                className="activity-card"
                            >
                                <div className="activity-img-wrapper">
                                    <img
                                        src={`/images/actividades/${actividad.id}.jpg`}
                                        alt={actividad.nombre}
                                        className="activity-img"
                                    />
                                    <div className="activity-overlay">
                                        <span className="activity-explore">
                                            Explorar
                                        </span>
                                    </div>
                                </div>
                                <p className="activity-title">
                                    {actividad.nombre}
                                </p>
                            </Link>
                        ))}
                    </div>
                </section>

                {/* --- SECCIÓN NOTICIAS --- */}
                <section className="section-noticias pb-20">
                    <h2 className="title-black">Últimas Noticias</h2>
                    <div className="noticia-container">
                        {noticias.slice(0, 4).map((noticia) => (
                            <Link
                                key={noticia.id}
                                href={`/noticias/${noticia.id}`}
                                className="news-card"
                            >
                                <div className="news-img-wrapper">
                                    <img
                                        src={`/images/noticias/${noticia.id}.jpg`}
                                        alt={noticia.titulo}
                                        className="news-img"
                                    />
                                </div>
                                <h4>{noticia.titulo}</h4>
                                <p>
                                    {noticia.resumen ||
                                        'Haz clic para leer más sobre esta noticia...'}
                                </p>
                            </Link>
                        ))}
                    </div>
                </section>
            </div>
        </>
    );
}

Inicio.layout = {
    breadcrumbs: [
        {
            title: 'Inicio',
            href: '/inicio',
        },
    ],
};
