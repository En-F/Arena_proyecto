import { Head, router, usePage } from '@inertiajs/react';
import '../../../css/actividad/inicio.css';
import Button from '@/components/Layouts/Button';
import Cartagenerica from '@/components/carta/Cartagenerica';

interface Centro {
    id: number;
    nombre: string;
}
interface Curso {
    id: number;
    nombre: string;
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
    esAdmin: boolean;
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
    esAdmin,
}: Props) {
    const { auth } = usePage().props as any;
    const is_admin = auth.user?.is_admin || false;
    const is_jefe = auth.user?.is_jefe || false;

    //CAMBIARDOR DE CENTRO
    const handleCentroChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        const value = e.target.value;
        router.get('/actividades', {
            centro_id: value || undefined,
            curso_id: undefined,
            tipo_id: tipoSeleccionado || undefined,
        });
    };

    //CAMBIADOR DE CURSO
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

    //CAMBIADOR DE TIPO
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
                                    {curso.nombre}
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
                    <div className="activities-grid">
                        {!centroSeleccionado && !estaAutenticado ? (
                            <p className="sin-centro-msg">
                                Selecciona un centro para ver sus actividades.
                            </p>
                        ) : actividades.length === 0 ? (
                            <div className="sin-centro-msg">
                                <p>
                                    {cursoSeleccionado
                                        ? 'No hay actividades para el curso seleccionado.'
                                        : 'No hay actividades para el centro seleccionado.'}
                                </p>
                                {(is_jefe || is_admin) && (
                                    <Cartagenerica
                                        esCrear={true}
                                        rutaCrear="/actividades/create"
                                        tipo="actividad"
                                    />
                                )}
                            </div>
                        ) : (
                            actividades.map((actividad) => (
                                <Cartagenerica
                                    key={actividad.id}
                                    id={actividad.id}
                                    nombre={actividad.nombre}
                                    imagen={actividad.imagen}
                                    tipo="actividad"
                                    rutaDetalle="/actividades"
                                    rutaOcultar="/actividades/ocultar"
                                    textoOcultar="Ocultar"
                                    textoConfirmacion="¿Estás seguro de que quieres ocultar este actividad?"
                                    es_activo={actividad.es_activo}
                                />
                            ))
                        )}
                        {actividades.length !== 0 && (is_admin || is_jefe) && (
                            <Cartagenerica
                                esCrear
                                rutaCrear="actividades/create"
                            />
                        )}
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
