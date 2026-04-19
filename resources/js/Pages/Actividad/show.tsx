import { Head } from '@inertiajs/react';
import Button from '@/components/Layouts/Button';
import '../../../css/actividad/show.css';
import CartaVideo from '@/components/carta/CartaVideo';
import CartaActividadShow from '@/components/carta/CartaActividadShow';

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
    return (
        <>
            <Head title={actividad.titulo} />
            <div className="main-container activity-detail-page">
                <div className="activity-hero-card">
                    <CartaActividadShow
                        id={actividad.id}
                        titulo={actividad.titulo}
                        imagen={actividad.imagen}
                        descripcion={actividad.descripcion}
                        nivel={actividad.nivel}
                    />
                </div>
                <section className="sub-activities-section">
                    <h2 className="sub-activities-title">
                        Actividades que se pueden realizar
                    </h2>

                    <div className="videos-grid">
                        {videos.map((video) => (
                            <CartaVideo
                                key={video.id}
                                id={video.id}
                                url={video.url}
                                titulo={video.titulo}
                            />
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
