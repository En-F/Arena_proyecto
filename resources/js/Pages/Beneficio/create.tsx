import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import '../../../css/noticia/formulario.css';
import { Input } from '@/components/ui/input';
import Button from '@/components/Layouts/Button';

interface Beneficio {
    id: number;
    titulo: string;
    descripcion: string;
}

interface Props {
    beneficio: Beneficio;
    curso: number;
}

export default function Edit({ beneficio, curso }: Props) {
    const { data, setData, post, processing, errors, setError, clearErrors } =
        useForm({
            titulo: '',
            descripcion: '',
            curso_id: curso || null,
        });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        clearErrors();

        let tieneErrores = false;

        const regexSoloLetras = /^[a-zA-ZÀ-ÿ\s]+$/;

        if (data.titulo && !regexSoloLetras.test(data.titulo)) {
            setError('titulo', 'El título solo puede contener letras.');
            tieneErrores = true;
        }

        if (!data.descripcion || data.descripcion.trim() === '') {
            setError('descripcion', 'El campo descripcion es obligatorio.');
            tieneErrores = true;
        }

        const camposObligatorios = [
            { id: 'titulo', valor: data.titulo, nombre: 'Título' },
            {
                id: 'descripcion',
                valor: data.descripcion,
                nombre: 'Descripcion',
            },
        ];

        camposObligatorios.forEach((campo) => {
            if (
                campo.valor === null ||
                campo.valor === undefined ||
                campo.valor.toString().trim() === ''
            ) {
                setError(
                    campo.id as any,
                    `El campo ${campo.nombre} es obligatorio.`,
                );
                tieneErrores = true;
            }
        });

        if (tieneErrores) return;

        post(route('beneficios.store'), {
            forceFormData: true,
        });
    };

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="cn-page">
                    <div className="cn-wrap">
                        <div className="cn-section-header">
                            <p className="cn-section-title">Crear beneficio</p>
                            <p className="cn-section-subtitle">
                                Esta información se mostrará públicamente. Sé
                                cuidadoso con lo que publicas.
                            </p>
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Título</label>
                            <Input
                                name="titulo"
                                placeholder="Escribe el titulo beneficio..."
                                value={data.titulo}
                                onChange={(e) =>
                                    setData('titulo', e.target.value)
                                }
                                className="cn-input"
                            />
                            {errors.titulo && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.titulo}
                                </span>
                            )}
                        </div>

                        <div className="cn-field">
                            <label className="cn-label">Descripción</label>
                            <textarea
                                name="descripcion"
                                placeholder="Escribe la descripción de la curso..."
                                rows={7}
                                className="cn-textarea"
                                value={data.descripcion || ''}
                                onChange={(e) =>
                                    setData('descripcion', e.target.value)
                                }
                            />
                            {errors.descripcion && (
                                <span className="mt-1 text-xs text-red-500">
                                    {errors.descripcion}
                                </span>
                            )}
                        </div>

                        <hr className="cn-divider" />

                        <div className="cn-actions">
                            <Button
                                href={route('cursos.show', curso)}
                                type="button"
                                className="cn-btn-cancel"
                            >
                                Cancelar
                            </Button>
                            <Button
                                type="submit"
                                className="cn-btn-save"
                                disabled={processing}
                            >
                                {processing
                                    ? 'Enviando...'
                                    : 'Guardar Beneficio'}
                            </Button>
                        </div>
                    </div>
                </div>
            </form>
        </>
    );
}
