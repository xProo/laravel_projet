// Voice Search Component with Native Web Speech API
class VoiceSearchNative {
    constructor() {
        this.isListening = false;
        this.searchResults = [];
        this.recognition = null;
        this.init();
    }

    init() {
        this.setupSpeechRecognition();
        this.createUI();
    }

    setupSpeechRecognition() {
        // Check if Web Speech API is supported
        if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
            console.warn('Web Speech API is not supported');
            this.showNotification('Reconnaissance vocale non supportée par votre navigateur', 'error');
            return;
        }

        // Initialize speech recognition
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        this.recognition = new SpeechRecognition();

        // Configure recognition
        this.recognition.continuous = false;
        this.recognition.interimResults = false;
        this.recognition.lang = 'fr-FR';
        this.recognition.maxAlternatives = 1;

        // Event listeners
        this.recognition.onstart = () => {
            this.isListening = true;
            this.updateUI();
            this.showNotification('Écoute en cours... Dites le nom d\'un produit', 'info');
        };

        this.recognition.onend = () => {
            this.isListening = false;
            this.updateUI();
        };

        this.recognition.onresult = (event) => {
            const transcript = event.results[0][0].transcript;
            console.log('Recognized:', transcript);
            
            // Process the transcript for search
            this.processVoiceCommand(transcript);
        };

        this.recognition.onerror = (event) => {
            console.error('Speech recognition error:', event);
            this.handleSpeechError(event);
        };

        this.recognition.onaudiostart = () => {
            console.log('Audio capturing started');
        };

        this.recognition.onaudioend = () => {
            console.log('Audio capturing ended');
        };

        this.recognition.onsoundstart = () => {
            console.log('Sound detected');
        };

        this.recognition.onsoundend = () => {
            console.log('Sound ended');
        };

        this.recognition.onspeechstart = () => {
            console.log('Speech started');
        };

        this.recognition.onspeechend = () => {
            console.log('Speech ended');
        };
    }

    processVoiceCommand(transcript) {
        const lowerTranscript = transcript.toLowerCase();
        
        // Check for stop commands
        if (lowerTranscript.includes('arrête') || lowerTranscript.includes('stop') || lowerTranscript.includes('pause')) {
            this.stopListening();
            return;
        }

        // Extract search terms from common phrases
        let searchTerm = transcript;
        
        // Remove common prefixes
        const prefixes = ['recherche', 'cherche', 'trouve', 'montre', 'donne'];
        for (const prefix of prefixes) {
            if (lowerTranscript.startsWith(prefix)) {
                searchTerm = transcript.substring(prefix.length).trim();
                break;
            }
        }

        // Perform search if we have a search term
        if (searchTerm && searchTerm.length > 0) {
            this.performVoiceSearch(searchTerm);
        } else {
            this.showNotification('Veuillez prononcer le nom d\'un produit', 'error');
        }
    }

    handleSpeechError(event) {
        this.isListening = false;
        this.updateUI();
        
        let errorMessage = 'Erreur de reconnaissance vocale';
        
        switch (event.error) {
            case 'network':
                errorMessage = 'Erreur réseau. Vérifiez votre connexion internet.';
                break;
            case 'not-allowed':
                errorMessage = 'Accès au microphone refusé. Veuillez autoriser l\'accès.';
                this.showMicrophonePermissionHelp();
                break;
            case 'no-speech':
                errorMessage = 'Aucune parole détectée. Veuillez parler plus fort.';
                break;
            case 'audio-capture':
                errorMessage = 'Erreur de capture audio. Vérifiez votre microphone.';
                break;
            case 'service-not-allowed':
                errorMessage = 'Service de reconnaissance vocale non autorisé.';
                break;
            case 'bad-grammar':
                errorMessage = 'Erreur de grammaire dans la reconnaissance.';
                break;
            case 'language-not-supported':
                errorMessage = 'Langue non supportée.';
                break;
            default:
                errorMessage = `Erreur: ${event.error}`;
        }
        
        this.showNotification(errorMessage, 'error');
    }

    showMicrophonePermissionHelp() {
        const helpMessage = `
            <div class="voice-help-modal">
                <h3>🔊 Autoriser l'accès au microphone</h3>
                <p>Pour utiliser la recherche vocale, vous devez autoriser l'accès au microphone :</p>
                <ol>
                    <li>Cliquez sur l'icône du microphone dans la barre d'adresse</li>
                    <li>Sélectionnez "Autoriser"</li>
                    <li>Actualisez la page</li>
                </ol>
                <button onclick="this.parentElement.remove()" class="voice-help-close">Fermer</button>
            </div>
        `;
        
        const helpDiv = document.createElement('div');
        helpDiv.innerHTML = helpMessage;
        helpDiv.className = 'voice-help-overlay';
        document.body.appendChild(helpDiv);
        
        this.addHelpModalStyles();
    }

    addHelpModalStyles() {
        if (!document.getElementById('voice-help-styles')) {
            const style = document.createElement('style');
            style.id = 'voice-help-styles';
            style.textContent = `
                .voice-help-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0, 0, 0, 0.5);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 10001;
                }
                
                .voice-help-modal {
                    background: white;
                    padding: 24px;
                    border-radius: 12px;
                    max-width: 400px;
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                }
                
                .voice-help-modal h3 {
                    color: #1f2937;
                    margin-bottom: 12px;
                    font-size: 18px;
                    font-weight: 600;
                }
                
                .voice-help-modal p {
                    color: #6b7280;
                    margin-bottom: 16px;
                }
                
                .voice-help-modal ol {
                    color: #374151;
                    margin-bottom: 20px;
                    padding-left: 20px;
                }
                
                .voice-help-modal li {
                    margin-bottom: 8px;
                }
                
                .voice-help-close {
                    background: #3b82f6;
                    color: white;
                    border: none;
                    padding: 8px 16px;
                    border-radius: 6px;
                    cursor: pointer;
                    font-weight: 500;
                }
                
                .voice-help-close:hover {
                    background: #2563eb;
                }
            `;
            document.head.appendChild(style);
        }
    }

    createUI() {
        // Create voice search button
        const voiceButton = document.createElement('button');
        voiceButton.id = 'voice-search-btn-native';
        voiceButton.className = 'voice-search-btn-native';
        voiceButton.innerHTML = `
            <svg class="voice-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
            </svg>
            <span class="voice-text">Recherche vocale (Native)</span>
        `;
        voiceButton.addEventListener('click', () => this.toggleListening());

        // Create search results container
        const resultsContainer = document.createElement('div');
        resultsContainer.id = 'voice-search-results-native';
        resultsContainer.className = 'voice-search-results-native';

        // Insert into page
        const searchContainer = document.querySelector('.search-container') || document.querySelector('.mb-6');
        if (searchContainer) {
            searchContainer.appendChild(voiceButton);
            searchContainer.appendChild(resultsContainer);
        }

        // Add CSS styles
        this.addStyles();
    }

    addStyles() {
        const style = document.createElement('style');
        style.textContent = `
            .voice-search-btn-native {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 10px 16px;
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                color: white;
                border: none;
                border-radius: 25px;
                cursor: pointer;
                font-weight: 500;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
                margin-left: 10px;
            }

            .voice-search-btn-native:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            }

            .voice-search-btn-native.listening {
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                animation: pulse 1.5s infinite;
            }

            .voice-search-btn-native.listening .voice-icon {
                animation: wave 1s infinite;
            }

            .voice-search-btn-native.error {
                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            }

            .voice-icon {
                width: 20px;
                height: 20px;
            }

            .voice-text {
                font-size: 14px;
            }

            .voice-search-results-native {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                max-height: 400px;
                overflow-y: auto;
                display: none;
            }

            .voice-search-results-native.show {
                display: block;
            }

            .voice-result-item {
                padding: 12px 16px;
                border-bottom: 1px solid #f3f4f6;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .voice-result-item:hover {
                background-color: #f9fafb;
            }

            .voice-result-item:last-child {
                border-bottom: none;
            }

            .voice-result-name {
                font-weight: 600;
                color: #1f2937;
                margin-bottom: 4px;
            }

            .voice-result-details {
                font-size: 12px;
                color: #6b7280;
            }

            .voice-result-price {
                color: #059669;
                font-weight: 600;
            }

            .voice-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 12px 20px;
                border-radius: 8px;
                color: white;
                font-weight: 500;
                z-index: 10000;
                animation: slideIn 0.3s ease;
                max-width: 300px;
                word-wrap: break-word;
            }

            .voice-notification.info {
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            }

            .voice-notification.success {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            }

            .voice-notification.error {
                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            }

            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }

            @keyframes wave {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.2); }
            }

            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }

    toggleListening() {
        if (this.isListening) {
            this.stopListening();
        } else {
            this.startListening();
        }
    }

    startListening() {
        if (!this.recognition) {
            this.showNotification('Reconnaissance vocale non disponible', 'error');
            return;
        }

        try {
            this.recognition.start();
        } catch (error) {
            console.error('Error starting speech recognition:', error);
            this.showNotification('Erreur lors du démarrage de la reconnaissance vocale', 'error');
        }
    }

    stopListening() {
        if (this.recognition) {
            try {
                this.recognition.stop();
            } catch (error) {
                console.error('Error stopping speech recognition:', error);
            }
        }
        this.hideResults();
    }

    async performVoiceSearch(query) {
        this.showNotification(`Recherche en cours pour: "${query}"`, 'info');
        
        try {
            const response = await fetch(`/api/products/search?q=${encodeURIComponent(query)}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            this.searchResults = data.products;
            this.displayResults();
            
            if (this.searchResults.length > 0) {
                this.showNotification(`${this.searchResults.length} produit(s) trouvé(s)`, 'success');
            } else {
                this.showNotification('Aucun produit trouvé', 'error');
            }
        } catch (error) {
            console.error('Search error:', error);
            this.showNotification('Erreur lors de la recherche. Vérifiez votre connexion internet.', 'error');
        }
    }

    displayResults() {
        const resultsContainer = document.getElementById('voice-search-results-native');
        if (!resultsContainer) return;

        if (this.searchResults.length === 0) {
            resultsContainer.innerHTML = '<div class="voice-result-item">Aucun produit trouvé</div>';
        } else {
            resultsContainer.innerHTML = this.searchResults.map(product => `
                <div class="voice-result-item" onclick="window.location.href='${product.url}'">
                    <div class="voice-result-name">${product.name}</div>
                    <div class="voice-result-details">
                        <span class="voice-result-price">${product.price}€</span> • 
                        ${product.category} • 
                        Stock: ${product.stock}
                    </div>
                </div>
            `).join('');
        }

        resultsContainer.classList.add('show');
    }

    hideResults() {
        const resultsContainer = document.getElementById('voice-search-results-native');
        if (resultsContainer) {
            resultsContainer.classList.remove('show');
        }
    }

    updateUI() {
        const button = document.getElementById('voice-search-btn-native');
        if (button) {
            button.classList.remove('listening', 'error');
            
            if (this.isListening) {
                button.classList.add('listening');
                button.querySelector('.voice-text').textContent = 'Écoute...';
            } else {
                button.querySelector('.voice-text').textContent = 'Recherche vocale (Native)';
            }
        }
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `voice-notification ${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 4000);
    }
}

// Initialize native voice search when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize if Web Speech API is supported
    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        new VoiceSearchNative();
    } else {
        console.warn('Web Speech API not supported');
    }
}); 