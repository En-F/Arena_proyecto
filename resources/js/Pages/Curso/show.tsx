import React from 'react';
import '../../../css/curso/show.css';
import { usePage, router } from '@inertiajs/react';
import CartaVideo from '@/components/carta/CartaVideo';
import '../../../css/actividad/show.css';
import { Trash2 } from 'lucide-react';
import { route } from 'ziggy-js';
import Button from '@/components/Layouts/Button';
import '../../../css/centro/inicio.css';

interface Beneficio {
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

    const handleEliminar = (id: number) => {
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
                <div>
                    <h2 className="section-title">Beneficios de la natación</h2>
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
