<style>
.fixed-buttons {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.fixed-button {
    width: 50px;
    height: 50px;
    background: linear-gradient(45deg, #1CA8CB, #113D48);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    font-size: 20px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    overflow: hidden;
    position: relative;
}

.fixed-button:hover {
    width: 150px;
    border-radius: 25px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.3);
}

.fixed-button .icon {
    position: absolute;
    right: 15px;
    transition: all 0.3s ease;
}

.fixed-button .text {
    opacity: 0;
    white-space: nowrap;
    font-size: 14px;
    font-weight: 500;
    transition: opacity 0.3s ease;
    margin-right: 40px;
}

.fixed-button:hover .icon {
    right: 15px;
}

.fixed-button:hover .text {
    opacity: 1;
}

.fixed-button.book {
    background: linear-gradient(45deg, #28a745, #20c997);
}

.fixed-button.whatsapp {
    background: linear-gradient(45deg, #25d366, #128c7e);
}

.fixed-button.call {
    background: linear-gradient(45deg, #dc3545, #c82333);
}
</style>

<div class="fixed-buttons">
    <a href="to_book/index.php" class="fixed-button book" title="Book Now">
        <span class="text">Book Now</span>
        <i class="fas fa-calendar-check icon"></i>
    </a>
    <a href="https://wa.me/918126052755?text=Hello%20India%20Day%20Trip%2C%20I%20would%20like%20to%20inquire%20about%20your%20tours." class="fixed-button whatsapp" target="_blank" title="WhatsApp">
        <span class="text">WhatsApp</span>
        <i class="fab fa-whatsapp icon"></i>
    </a>
    <a href="tel:+918126052755" class="fixed-button call" title="Call Now">
        <span class="text">Call Now</span>
        <i class="fas fa-phone icon"></i>
    </a>
</div>