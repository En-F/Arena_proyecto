<<<<<<< HEAD
import { Head, Link, router } from '@inertiajs/react';
import '../../../css/actividad/inicio.css';
import Button from '@/components/Layouts/Button';
import CartaActividad from '@/components/carta/CartaActividad';
=======
import { Head, router } from '@inertiajs/react';
import '../../../css/actividad/inicio.css';
import Button from '@/components/Layouts/Button';
import CartaActividad from '../../components/carta/CartaActividad';
>>>>>>> fb55ae0 (Intregración de las cookies)

interface Centro {
    id: number;
    nombre: string;
}
interface Curso {
    id: number;
    titulo: string;
}
interface Tipo {
    id: number;
    tipo: string;
}
interface Actividad {
    id: number;
    titulo: string;
    imagen: string;
}
interface Props {
    actividades: Actividad[];
    tipos: Tipo[];
    centros: Centro[];
    cursos: Curso[];
    centroSeleccionado: number | null;
    cursoSeleccionado: number | null;
    tipoSeleccionado: number | null;
    estaAutenticado: boolean;
    sinCentro: boolean;
<<<<<<< HEAD
=======
    esAdmin: boolean;
>>>>>>> fb55ae0 (Intregración de las cookies)
}

export default function Inicio({
    actividades,
    tipos,
    centros,
    cursos,
    centroSeleccionado,
    cursoSeleccionado,
    tipoSeleccionado,
    estaAutenticado,
    sinCentro,
<<<<<<< HEAD
}: Props) {

    // Cambiador del centro
    const handleCentroChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const value = e.target.value;
        router.get(
            '/actividades',
            {
                centro_id: value || undefined,
                curso_id: undefined,
                tipo_id: tipoSeleccionado || undefined,
            },
            { preserveScroll: true },
        );
    };

    // Cambiador del curso
=======
    esAdmin
}: Props) {
    //CAMBIARDOR DE CENTRO
    const handleCentroChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const value = e.target.value;
        router.get('/actividades', {
            centro_id: value || undefined,
            curso_id: undefined,
            tipo_id: tipoSeleccionado || undefined,
        });
    };

    //CAMBIARDOR DE CURSO
>>>>>>> fb55ae0 (Intregración de las cookies)
    const handleCursoChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const value = e.target.value;
        router.get(
            '/actividades',
            {
                centro_id: centroSeleccionado || undefined,
                curso_id: value || undefined,
                tipo_id: tipoSeleccionado || undefined,
            },
            { preserveScroll: true },
        );
    };

<<<<<<< HEAD
    // Cambiador del tipo
=======
    //CAMBIADOR DE TIPO
>>>>>>> fb55ae0 (Intregración de las cookies)
    const handleTipoChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const value = e.target.value;
        router.get(
            '/actividades',
            {
                centro_id: centroSeleccionado || undefined,
                curso_id: cursoSeleccionado || undefined,
                tipo_id: value || undefined,
            },
            { preserveScroll: true },
        );
    };

<<<<<<< HEAD
    return (
        <>
            <Head title="Inicio " />
            {estaAutenticado && sinCentro ? (
                // CASO 1: Autenticado pero sin centro asignado
                <p className="sin-centro-msg">
                    No estás inscrito en ningún centro. Contacta con un
                    administrador para que te asigne uno.
                </p>
            ) : (<div className="elementos">
                    {/* // SEGUIMOS MAÑANA */}
                </div>)
=======
    if (estaAutenticado && sinCentro) {
        return (
            <>
                <Head title="Actividades" />
                <div className="main-container">
                    <section className="section-actividades">
                        <h2 className="title-black text-white">
                            Actividades Deportivas
                        </h2>
                        {estaAutenticado && sinCentro && !esAdmin && (
                            <p className="sin-centro-msg">
                                No estás inscrito en ningún centro...
                            </p>
                        )}
                        <Button
                            href="/inicio"
                            type="button"
                            className="btn-volver btn-crud"
                        >
                            Volver
                        </Button>
                    </section>
                </div>
            </>
        );
    }

    return (
        <>
            <Head title="Actividades" />
>>>>>>> fb55ae0 (Intregración de las cookies)
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
<<<<<<< HEAD
                    <form
                        action="/actividades/buscar"
                        method="get"
                        className="form"
                    >
                        <div className="elementos">
                            <select
                                name="centros"
                                id="centros"
                                className="select-deporte"
                            >
                                <option selected value="0">
                                    Seleccciona un centro
                                </option>
                                {centros.map((centro) => (
                                    <option key={centro.id} value={centro.id}>
                                        {centro.nombre}
                                    </option>
                                ))}
                            </select>
                            <select
                                name="cursos"
                                id="cursos"
                                className="select-deporte"
                            >
                                <option selected value="0">
                                    Seleccciona un curso
                                </option>
                                {cursos.map((curso) => (
                                    <option key={curso.id} value={curso.id}>
                                        {curso.titulo}
                                    </option>
                                ))}
                            </select>
                            <select
                                name="tipos"
                                id="tipos"
                                className="select-deporte"
                            >
                                <option selected>Tipo</option>
                                {tipos.map((tipo) => (
                                    <option key={tipo.id} value={tipo.id}>
                                        {tipo.tipo}
                                    </option>
                                ))}
                            </select>
                            <Button
                                type="submit"
                                className="btn-filtrar btn-crud"
                                href=""
                            >
                                Filtrar
                            </Button>
                        </div>
                    </form>
                    <div className="activities-grid">
                        {actividades.map((actividad) => (
                            <CartaActividad
                                key={actividad.id}
                                id={actividad.id}
                                titulo={actividad.titulo}
                                imagen={actividad.imagen}
                            />
                        ))}
=======
                    <div className="elementos">
                        <select
                            name="centros"
                            id="centros"
                            className="select-deporte"
                            value={centroSeleccionado ?? ''}
                            onChange={handleCentroChange}
                        >
                            {!estaAutenticado && (
                                <option value="">Selecciona un centro</option>
                            )}
                            {centros.map((centro) => (
                                <option key={centro.id} value={centro.id}>
                                    {centro.nombre}
                                </option>
                            ))}
                        </select>
                        <select
                            name="cursos"
                            id="cursos"
                            className="select-deporte"
                            value={cursoSeleccionado ?? ''}
                            onChange={handleCursoChange}
                            disabled={!centroSeleccionado}
                        >
                            <option value="">Todos los cursos</option>
                            {cursos.map((curso) => (
                                <option key={curso.id} value={curso.id}>
                                    {curso.titulo}
                                </option>
                            ))}
                        </select>
                        <select
                            name="tipos"
                            id="tipos"
                            className="select-deporte"
                            value={tipoSeleccionado ?? ''}
                            onChange={handleTipoChange}
                            disabled={!centroSeleccionado}
                        >
                            <option value="">Todos los tipos</option>
                            {tipos.map((tipo) => (
                                <option key={tipo.id} value={tipo.id}>
                                    {tipo.tipo}
                                </option>
                            ))}
                        </select>
                    </div>
                    {/* // Caso 3 sin centro elegido*/}
                    <div className="activities-grid">
                        {!centroSeleccionado && !estaAutenticado ? (
                            <p className="sin-centro-msg">
                                Selecciona un centro para ver sus actividades.
                            </p>
                        ) : actividades.length === 0 ? (
                            <p className="sin-centro-msg">
                                {cursoSeleccionado 
                                    ? "No hay actividades para el curso seleccionado." 
                                    : "No hay actividades para el centro seleccionado."}
                            </p>
                        ) : (
                            actividades.map((actividad) => (
                                <CartaActividad
                                    key={actividad.id}
                                    id={actividad.id}
                                    titulo={actividad.titulo}
                                    imagen={actividad.imagen}
                                />
                            ))
                        )}
>>>>>>> fb55ae0 (Intregración de las cookies)
                    </div>
                    <Button
                        href="/inicio"
                        type="button"
                        className="btn-volver btn-crud"
                    >
                        Volver
                    </Button>
                </section>
            </div>
        </>
    );
}
