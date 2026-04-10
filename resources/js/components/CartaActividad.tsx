// resources/js/Components/ActivityCard.jsx
import React from 'react';

export default function CartaActividad({ title, imagen }) {
    return (
        <div className="activity-card">
            <div className="activity-img-wrapper">
                <img src={imagen} alt={title} className="activity-img" />
                {/* Capa oscura que aparece al hacer hover */}
                <div className="activity-overlay">
                    <span className="activity-explore">Explorar</span>
                </div>
            </div>
            <h4 className="activity-title">{title}</h4>
        </div>
    );
}
