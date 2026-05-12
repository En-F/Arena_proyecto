import '../../../css/curso/show.css';
import { usePage, router } from '@inertiajs/react';
import CartaVideo from '@/components/carta/CartaVideo';
import '../../../css/actividad/show.css';
import { Trash2 } from 'lucide-react';
import { route } from 'ziggy-js';
import Button from '@/components/Layouts/Button';
import '../../../css/centro/inicio.css';
import '../../../css/noticia/show.css';

interface Beneficio {
    id: number;
    titulo: string;
    descripcion: string;
}

interface Curso {
    id: number;
    nombre: string;
    descripcion: number;
    tipo: string;
}

interface Video {
    id: number;
    titulo: string;
    url: string;
}

interface Props {
    curso: Curso;
    videos: Video[];
    beneficios: Beneficio[];
}

const show = ({ curso, videos, beneficios }: Props) => {
    const { auth } = usePage().props;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    const handleEdit = (beneficioId, cursoId) => {
        router.delete(route('beneficios.edit', beneficioId), {
            curso_id: cursoId,
        });
    };

    const handleBorrarBeneficio = (id: number) => {
        if (confirm(`¿Estás seguro de que quieres eliminar este beneficio ?`)) {
            router.delete(route('beneficios.destroy', id), {
                data: { curso_id: curso },
                preserveScroll: true,
            });
        }
    };

    const handleBorrarCurso = (id: number) => {
        if (confirm(`¿Estás seguro de que quieres eliminar este beneficio ?`)) {
            router.delete(route('cursos.destroy', id), {
                preserveScroll: true,
            });
        }
    };

    const handleEliminarVideo = (id: number) => {
        if (confirm('¿Estás seguro de que quieres quitar este vídeo?')) {
            router.delete(route('videos.destroy', id), {
                data: {
                    regresar_a_id: curso.id,
                    tipo: 'curso',
                },
                preserveScroll: true,
            });
        }
    };

    return (
        <div className="main-container">
            <section className="section-centros">
                <h2 className="section-title">{curso.nombre}</h2>
                <p className="descripcion-centros">{curso.descripcion} </p>
                {(is_admin || is_jefe) && (
                    <div className="botones-acciones">
                        <Button
                            href={route('cursos.edit', curso.id)}
                            className="btn btn-info"
                        >
                            Editar
                        </Button>

                        <Button
                            onClick={() => handleBorrarCurso(curso.id)}
                            className="btn btn-error"
                        >
                            Eliminar
                        </Button>
                    </div>
                )}
                <div>
                    <h2 className="section-title">Beneficios de la natación</h2>
                    {(is_admin || is_jefe) && (
                        <div className="botones">
                            <Button
                                href={route('beneficios.create', {
                                    curso: curso.id,
                                })}
                                className="btn-beneficio-create"
                            >
                                Crear un beneficio{' '}
                            </Button>
                            <Button
                                href={route('beneficios.biblioteca')}
                                className="btn-beneficio-create"
                            >
                                Añadir uno de la biblioteca{' '}
                            </Button>
                        </div>
                    )}
                </div>
                <div className="benefits-list">
                    {beneficios.map((beneficio, index) => (
                        <div
                            key={beneficio.id || index}
                            className="benefit-item"
                        >
                            <h3 className="benefit-title">
                                {beneficio.titulo}
                            </h3>
                            <p className="benefit-text">
                                {beneficio.descripcion}
                            </p>
                            {(is_admin || is_jefe) && (
                                <div className="botones-acciones">
                                    <Button
                                        onClick={() =>
                                            handleEdit(beneficio.id, curso.id)
                                        }
                                        className="btn btn-info"
                                    >
                                        Editar
                                    </Button>

                                    <Button
                                        onClick={() =>
                                            handleBorrarBeneficio(beneficio.id)
                                        }
                                        className="btn btn-error"
                                    >
                                        Eliminar
                                    </Button>
                                </div>
                            )}
                        </div>
                    ))}
                </div>
                <section className="sub-activities-section">
                    <h2 className="sub-activities-title">
                        Videos relacionados
                    </h2>
                    {(is_admin || is_jefe) && (
                        <div className="botones-acciones">
                            <Button
                                href={route('videos.create', {
                                    curso_id: curso.id,
                                })}
                                className="btn-crud btn-video-create"
                            >
                                Añadir Video
                            </Button>
                        </div>
                    )}

                    <div className="videos-grid">
                        {videos.map((video) => (
                            <div key={video.id} className="group relative">
                                <CartaVideo
                                    id={video.id}
                                    titulo={video.titulo}
                                    url={video.url}
                                />

                                {(is_admin || is_jefe) && (
                                    <button
                                        onClick={() =>
                                            handleEliminarVideo(video.id)
                                        }
                                        className="absolute top-2 right-2 rounded-full bg-red-600 p-2 text-white opacity-0 transition-opacity group-hover:opacity-100"
                                    >
                                        <Trash2 className="h-4 w-4" />{' '}
                                    </button>
                                )}
                            </div>
                        ))}
                    </div>

                    <div className="back-button-container">
                        <Button href="/cursos" className="btn-volver btn-crud">
                            Volver
                        </Button>
                    </div>
                </section>
            </section>
        </div>
    );
};

export default show;
