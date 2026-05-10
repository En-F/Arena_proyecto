import '../../../css/actividad/show.css';
import CartaVideo from '@/components/carta/CartaVideo';
import CartaActividadShow from '@/components/carta/CartaActividadShow';
import Button from '@/components/Layouts/Button';
import '../../../css/button.css';
import { Head, usePage, router } from '@inertiajs/react';
import { Trash2 } from 'lucide-react';
import { route } from 'ziggy-js';

interface Actividad {
    id: number;
    titulo: string;
    duracion: number;
    nivel: string;
    descripcion: string;
    imagen: string;
}

interface Props {
    actividad: Actividad;
    videos: any[];
}

export default function Show({ actividad, videos }: Props) {
    const { auth } = usePage().props;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    const handleEliminar = (id: number) => {
        if (confirm('¿Estás seguro de que quieres quitar este vídeo?')) {
            router.delete(route('videos.destroy', id), {
                data: {
                    regresar_a_id: actividad.id,
                    tipo: 'actividad',
                },
                preserveScroll: true,
            });
        }
    };

    return (
        <>
            <Head title={actividad.nombre} />
            <div className="main-container activity-detail-page">
                <div className="activity-hero-card">
                    <CartaActividadShow
                        id={actividad.id}
                        nombre={actividad.nombre}
                        imagen={actividad.imagen}
                        descripcion={actividad.descripcion}
                        nivel={actividad.nivel}
                    />
                </div>
                <section className="sub-activities-section">
                    <h2 className="sub-activities-title">
                        Actividades que se pueden realizar
                    </h2>
                    {(is_admin || is_jefe) && (
                        <div className="botones-acciones">
                            <Button
                                href={route('videos.create', {
                                    actividad_id: actividad.id,
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
                                        onClick={() => handleEliminar(video.id)}
                                        className="absolute top-2 right-2 rounded-full bg-red-600 p-2 text-white opacity-0 transition-opacity group-hover:opacity-100"
                                    >
                                        <Trash2 className="h-4 w-4" />{' '}
                                    </button>
                                )}
                            </div>
                        ))}
                    </div>

                    <div className="back-button-container">
                        <Button
                            href="/actividades"
                            className="btn-volver btn-crud"
                        >
                            Volver
                        </Button>
                    </div>
                </section>
            </div>
        </>
    );
}
