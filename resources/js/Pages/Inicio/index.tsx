import { Head } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import '../../../css/inicio.css';
import BannerInscripcion from '../../components/banner/BannerInscripcion';
import Cartagenerica from '@/components/carta/Cartagenerica';
import CartaNoticia from '@/components/carta/noticia/CartaNoticia';

interface Props {
    centros: any[];
    noticias: any[];
    cursos: any[];
}

export default function Inicio({ centros, noticias, cursos }: Props) {
    const { auth } = usePage().props as any;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;
    const c_centro = auth.user?.centros.lenght;
    return (
        <>
            <Head title="Inicio " />
            <div className="main-container">
                <section className="section-centros">
                    <h2 className="title-black">Nuestros Centros</h2>

                    <div className="grid-centros">
                        {centros.slice(0, 4).map((centro) => (
                            <Cartagenerica
                                key={centro.id}
                                id={centro.id}
                                nombre={centro.nombre}
                                imagen={centro.imagen}
                                tipo="centro"
                                rutaDetalle="/centros"
                                rutaOcultar="/centros/ocultar"
                                textoOcultar="Ocultar"
                            />
                        ))}
                        {is_admin && <Cartagenerica esCrear />}
                    </div>
                </section>

                {(!auth.user || !c_centro === 0) && (
                    <section className="banner-cta">
                        <BannerInscripcion
                            imagen="inscripcion.jpg"
                            titulo="¡Inscríbete Ahora!"
                            descripcion="Únete a nuestras actividades deportivas y disfruta de una experiencia única."
                            textBoton="Haz tu Inscripción"
                            href="/socio"
                        />
                    </section>
                )}

                <section className="section-actividades">
                    <h2 className="title-black text-white">
                        Cursos Deportivos
                    </h2>
                    <div className="grid-centros">
                        {cursos.slice(0, 4).map((curso) => (
                            <Cartagenerica
                                key={curso.id}
                                id={curso.id}
                                nombre={curso.nombre}
                                imagen={curso.imagen}
                                tipo="curso"
                                rutaCrear="/cursos/create"
                                rutaDetalle="/cursos"
                                rutaOcultar="/cursos/ocultar"
                                textoOcultar="Ocultar"
                            />
                        ))}
                        {(is_admin || is_jefe) && (
                            <Cartagenerica esCrear rutaCrear="/cursos/create" />
                        )}
                    </div>
                </section>

                <section className="section-noticias pb-20">
                    <h2 className="title-black">Últimas Noticias</h2>
                    <div className="noticia-container">
                        {noticias.map((noticia) => (
                            <CartaNoticia
                                key={noticia.id}
                                id={noticia.id}
                                titulo={noticia.titulo}
                                imagen={noticia.imagen}
                                contenido={noticia.contenido}
                                esCrear={false}
                                es_activo={noticia.es_activo}
                            />
                        ))}
                        {(is_admin || is_jefe) && <CartaNoticia esCrear />}
                    </div>
                </section>
            </div>
        </>
    );
}
