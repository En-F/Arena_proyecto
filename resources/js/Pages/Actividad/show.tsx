import { Head } from '@inertiajs/react';
import '../../../css/actividad/show.css';

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
}

export default function Show({ actividad }: Props) {
    return (
        <>
            <Head title={actividad.titulo} />
            <div className="main-container activity-detail-page">
                <div className="activity-hero-card">
                    <div className="hero-content-text">
                        <h1 className="hero-title">{actividad.titulo}</h1>

                        <div className="hero-meta">
                            <span className="meta-item">
                                📊 {actividad.nivel}
                            </span>
                        </div>

                        <p className="hero-description">
                            {actividad.descripcion}
                        </p>
                    </div>

                    <div className="hero-image-container">
                        <img
                            src={`/storage/${actividad.imagen}`}
                            alt={actividad.titulo}
                            className="hero-image"
                        />
                    </div>
                </div>
            </div>
        </>
    );
}

// <section className="sub-activities-section">
//                     <h2 className="sub-activities-title">
//                         Actividades que se pueden realizar
//                     </h2>

//                     <div className="videos-grid">
//                         {/* Aquí mapeamos los videos. Si no tienes en la DB,
//                             he puesto un ejemplo de cómo se vería el loop */}
//                         {videosRelacionados.map((video, index) => (
//                             <div key={index} className="video-card-wrapper">
//                                 <div className="video-card">
//                                     <img
//                                         src={video.thumbnail}
//                                         alt={video.nombre}
//                                     />
//                                     <div className="play-button-overlay">
//                                         <div className="play-icon"></div>
//                                     </div>
//                                     <div className="video-card-label">
//                                         {video.nombre}
//                                     </div>
//                                 </div>
//                                 <p className="video-footer-title">
//                                     {video.nombre}
//                                 </p>
//                             </div>
//                         ))}
//                     </div>

//                     <div className="back-button-container">
//                         <Link href="/actividades" className="btn-volver">
//                             Volver
//                         </Link>
//                     </div>
//                 </section>
