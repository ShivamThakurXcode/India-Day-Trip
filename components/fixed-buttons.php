<style>
.fixed-buttons {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 900;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.fixed-button {
    width: 40px;
    height: 40px;
    background: var(--theme-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    overflow: hidden;
    position: relative;
}

.fixed-button:hover {
    background: #113D48;
    box-shadow: 0 6px 15px rgba(0,0,0,0.3);
}

.fixed-button:hover .icon {
    color: white;
}

</style>

<div class="fixed-buttons">
    <a href="../to_book/index.php" class="fixed-button book" title="Book Now">
        <i class="fas fa-calendar-check icon"></i>
    </a>
    <a href="https://wa.me/918126052755?text=Hello%20India%20Day%20Trip%2C%20I%20would%20like%20to%20inquire%20about%20your%20tours." class="fixed-button whatsapp" target="_blank" title="WhatsApp">
        <i class="fab fa-whatsapp icon"></i>
    </a>
    <a href="tel:+918126052755" class="fixed-button call" title="Call Now">
        <i class="fas fa-phone icon"></i>
    </a>
</div>