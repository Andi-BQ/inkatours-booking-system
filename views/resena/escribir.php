<?php require_once __DIR__ . '/../partials/header.php'; ?>

<?php $reserva = $data['reserva']; ?>

<div class="destino-show-container">
    <section class="destino-hero" style="background-image: url('/Inkatours/static/img/<?php echo $reserva['item_path']; ?>/<?php echo htmlspecialchars($reserva['item_imagen']); ?>');">
        <div class="hero-content">
            <h1>Escribe tu Reseña</h1>
            <p>Comparte tu experiencia sobre "<?php echo htmlspecialchars($reserva['item_nombre']); ?>"</p>
        </div>
    </section>

    <div class="container" style="margin-top: -5rem; z-index: 10; position: relative;">
        <div class="form-card-review">
            <h3 class="form-title">Crea tu Reseña</h3>
            <p class="form-subtitle">Tu opinión es importante para otros viajeros.</p>
            <form action="/Inkatours/resena/guardar" method="POST">
                <input type="hidden" name="elemento_id" value="<?php echo $reserva['elemento_id']; ?>">
                <input type="hidden" name="tipo" value="<?php echo $reserva['tipo']; ?>">

                <div class="form-group text-center">
                    <label for="calificacion">Tu Calificación</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="calificacion" value="5" required/><label for="star5" title="5 stars">★</label>
                        <input type="radio" id="star4" name="calificacion" value="4" /><label for="star4" title="4 stars">★</label>
                        <input type="radio" id="star3" name="calificacion" value="3" /><label for="star3" title="3 stars">★</label>
                        <input type="radio" id="star2" name="calificacion" value="2" /><label for="star2" title="2 stars">★</label>
                        <input type="radio" id="star1" name="calificacion" value="1" /><label for="star1" title="1 star">★</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="titulo">Título de tu reseña</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ej: ¡Una experiencia inolvidable!" required>
                </div>

                <div class="form-group">
                    <label for="comentario">Tu reseña</label>
                    <textarea id="comentario" name="comentario" rows="5" class="form-control" placeholder="Describe tu experiencia, ¿qué fue lo que más te gustó?" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Enviar Reseña</button>
            </form>
        </div>
    </div>
</div>

<style>
.form-card-review {
    background: #fff;
    padding: 2.5rem;
    border-radius: var(--border-radius-large, 1rem); /* Assuming a larger radius variable exists or fallback */
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    max-width: 700px;
    margin: 0 auto;
}
.form-title {
    text-align: center;
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
}
.form-subtitle {
    text-align: center;
    color: var(--gray);
    margin-bottom: 2rem;
}
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    padding: 1rem 0;
}
.star-rating input {
    display: none;
}
.star-rating label {
    font-size: 2.5rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s ease-in-out;
    padding: 0 0.3rem;
}
.star-rating input:checked ~ label,
.star-rating:not(:checked) > label:hover,
.star-rating:not(:checked) > label:hover ~ label {
    color: #f39c12;
}
.form-group label {
    font-weight: 600;
    margin-bottom: 0.75rem;
    display: block;
}
.text-center {
    text-align: center;
}
/* Re-using destino-hero styles from the main stylesheet is assumed */
.destino-hero {
    height: 40vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
    position: relative;
    background-size: cover;
    background-position: center;
}
.destino-hero::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}
.hero-content {
    z-index: 2;
}
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
