import React from 'react';
import { Head } from '@inertiajs/react';
import { Download } from 'lucide-react';

export default function PaymentsShow({ usuario, pagos }: any) {
    const formatMoney = (dinero: number) => {
        //Formatea dinero segun el País
        return new Intl.NumberFormat('es-ES', {
            // €
            style: 'currency',
            currency: 'EUR',
        }).format(dinero / 100);
    };

    const formatDate = (timestamp: number) => {
        return new Date(timestamp * 1000).toLocaleDateString('es-ES', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });
    };

    return (
        <>
            <Head title={`Pagos de ${usuario.name}`} />

            <div className="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
                <div className="mb-8">
                    <h1 className="text-2xl font-bold text-gray-800">
                        Expediente de Pagos: {usuario.name}
                    </h1>
                    <p className="text-gray-600">
                        ID Cliente:{' '}
                        <code className="rounded bg-gray-100 px-2 py-1">
                            {usuario.stripe_customer_id || 'Sin vincular'}
                        </code>
                    </p>
                </div>

                <div className="overflow-hidden rounded-lg bg-white shadow">
                    <div className="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                        <h3 className="text-lg font-medium text-gray-900">
                            Historial de Transacciones
                        </h3>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Fecha
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Concepto ID
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Importe
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Estado
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Método
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Factura
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {pagos.length > 0 ? (
                                    pagos.map((pago: any) => (
                                        <tr key={pago.id}>
                                            <td className="px-6 py-4 text-sm whitespace-nowrap text-gray-900">
                                                {formatDate(pago.created)}
                                            </td>
                                            <td className="px-6 py-4 font-mono text-xs whitespace-nowrap text-gray-500">
                                                {pago.id}
                                            </td>
                                            <td className="px-6 py-4 text-sm font-bold whitespace-nowrap text-gray-900">
                                                {formatMoney(pago.amount)}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    className={`rounded-md px-2 py-1 text-xs ${pago.status === 'succeeded' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800'}`}
                                                >
                                                    {pago.status.toUpperCase()}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 text-sm whitespace-nowrap text-gray-500">
                                                {pago.payment_method_types[0]}
                                            </td>
                                            <td className="px-6 py-4 text-sm whitespace-nowrap">
                                                {pago.invoice_pdf ? (
                                                    <a
                                                        href={pago.invoice_pdf}
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        className="flex items-center text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        <Download
                                                            size={16}
                                                            className="mr-1"
                                                        />
                                                        PDF
                                                    </a>
                                                ) : (
                                                    <span className="text-xs text-gray-400 italic">
                                                        No disponible
                                                    </span>
                                                )}
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td
                                            colSpan={5}
                                            className="px-6 py-10 text-center text-gray-500 italic"
                                        >
                                            No hay pagos registrados para este
                                            usuario.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </>
    );
}
