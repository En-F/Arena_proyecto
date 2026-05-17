import '../../../css/curso/show.css';
import { usePage, router } from '@inertiajs/react';
import CartaVideo from '@/components/carta/CartaVideo';
import '../../../css/actividad/show.css';
import { Trash2 } from 'lucide-react';
import { route } from 'ziggy-js';
import Button from '@/components/Layouts/Button';
import '../../../css/centro/inicio.css';
import '../../../css/noticia/show.css';
import Headershow from '@/components/carta/centro_show/Headershow';
import BeneficiosSection from '@/components/curso/curso_show/beneficios/BeneficioSection';

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
}

const show = ({ curso, videos, beneficios }: Props) => {
    const { auth } = usePage().props;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    const handleBorrarCurso = (id: number) => {
        if (confirm(`¿Estás seguro de que quieres eliminar este curso ?`)) {
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
        <div className="container">
            <Headershow entidad={curso} tipo="curso" />
            <BeneficiosSection
                beneficios={beneficios}
                cursoId={curso.id}
            ></BeneficiosSection>
            <section className="sub-activities-section">
                <h2 className="sub-activities-title">Videos relacionados</h2>
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
        </div>
    );
};

export default show;
