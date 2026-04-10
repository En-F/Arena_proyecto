import React from 'react';

export default function CartaNoticia({ date, text, imagen }) {
    return (
        <div className="news-card">
            <span className="date-label">{date}</span>
            <div className="news-img-box">
                {imagen && <img src={imagen} alt="Noticia" />}
            </div>
            <p className="news-text">{text}</p>
        </div>
    );
}
