import { Head, Link } from '@inertiajs/react';
import '../../../css/actividad/inicio.css';
import Button from '@/components/Layouts/Button';
import CartaActividad from '@/components/carta/CartaActividad';

interface Props {
    actividades: any[];
}

export default function Inicio({ actividades }: Props) {
    return (
        <>
            <Head title="Inicio " />
            <div className="main-container">
                <section className="section-actividades">
                    <h2 className="title-black text-white">
                        Actividades Deportivas
                    </h2>
                    <p className="descripcion-actividad">
                        Conoce nuestro centro, un espacio diseñado para
                        motivarte, acompañarte y ayudarte a superar tus límites
                        con instalaciones modernas, entrenadores profesionales y
                        un ambiente único en el que cada detalle está pensado
                        para tu bienestar.
                    </p>
                    <div className="activities-grid">
                        {actividades.slice(0, 4).map((actividad) => (
                            <CartaActividad
                                id={actividad.id}
                                titulo={actividad.titulo}
                                imagen={actividad.imagen}
                            />
                        ))}
                    </div>
                    <Button href="/inicio" className="btn-volver btn-crud">
                        Volver
                    </Button>
                </section>
            </div>
        </>
    );
}
