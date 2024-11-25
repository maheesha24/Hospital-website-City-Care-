document.addEventListener('DOMContentLoaded', function () {
    const chatBox = document.querySelector('.chat-box');
    const chatToggle = document.querySelector('#chat-toggle');
    const sendBtn = document.querySelector('#send-btn');
    const userInput = document.querySelector('#user-input');
    const chatBody = document.querySelector('#chat-body');

    // Toggle chat box visibility
    chatToggle.addEventListener('click', function () {
        chatBox.style.display = chatBox.style.display === 'none' ? 'block' : 'none';
    });

    // Predefined responses
    const responses = {
        "hi": "Hello! How can I assist you today?",
        "hello": "Hi there! How can I help?",
        "how are you": "I'm just a bot, but I'm here to help you!",
        "what is your name": "I'm your friendly chat bot. I don't have a name.",
        "help": "Sure, I'm here to help! What do you need assistance with?",
        "contact": "You can contact us at info@citycarehospital.com.",
        "location": "We are located at 123 Health Street, Cityville, ST 12345.",
        "hours": "Our office hours are Monday - Friday: 9:00 AM - 6:00 PM, Saturday: 9:00 AM - 2:00 PM, Sunday: Closed.",
        "appointment": "You can book an appointment by calling us or visiting our website.",
        "doctor": "We have many qualified doctors. Please visit our website for more information.",
        "services": "We offer a range of services including general consultation, surgery, and pediatric care.",
        "insurance": "We accept various insurance plans. Please contact our office for details.",
        "emergency": "In case of an emergency, please call 911 or visit the nearest emergency room.",
        "billing": "For billing inquiries, please contact our billing department at billing@citycarehospital.com.",
        "payment": "We accept various payment methods including credit cards and cash.",
        "hours of operation": "Our hours of operation are Monday to Friday, 9 AM to 6 PM.",
        "feedback": "We value your feedback! Please send us your comments at feedback@citycarehospital.com.",
        "appointment booking": "You can book an appointment online or by calling our office.",
        "medical records": "For medical record requests, please contact our records department at records@citycarehospital.com.",
        "prescription": "If you need a prescription refill, please contact your doctor or our pharmacy.",
        "refer a friend": "You can refer a friend by sharing our contact information with them.",
        "hospital tour": "We offer hospital tours upon request. Please contact our office to schedule one.",
        "contact information": "You can reach us via email at info@citycarehospital.com or call us at (123) 456-7890.",
        "general inquiry": "For general inquiries, feel free to ask me any questions you have.",
        "staff": "Our staff includes experienced doctors, nurses, and support personnel.",
        "cleaning": "Our facility is cleaned regularly to ensure a safe and hygienic environment.",
        "hospital policy": "Please review our hospital policies on our website or contact us for more information.",
        "privacy": "We value your privacy and ensure that your information is kept confidential.",
        "emergency contact": "In case of an emergency, please call 911 or visit the nearest emergency room.",
        "consultation": "For a consultation, please call us or schedule an appointment online.",
        "surgery": "We offer a range of surgical procedures. Please contact our office for more details.",
        "pediatrics": "Our pediatricians provide comprehensive care for children of all ages.",
        "urgent care": "For urgent care, please visit our emergency room or contact us immediately.",
        "discharge": "For discharge information, please speak with your healthcare provider or contact our office.",
        "room service": "Room service is available for patients. Please contact our staff for assistance.",
        "food": "We offer a variety of meals for patients. If you have specific dietary needs, please let us know.",
        "prescription refill": "For prescription refills, please contact your pharmacy or doctor.",
        "visiting hours": "Our visiting hours are from 10 AM to 8 PM daily.",
        "visitor information": "For visitor information, please contact our front desk or visit our website.",
        "patient rights": "Patients have the right to receive respectful and compassionate care.",
        "medical advice": "For medical advice, please consult with your healthcare provider.",
        "health tips": "Maintaining a balanced diet and regular exercise are key to good health.",
        "wellness": "We offer wellness programs to promote overall health and well-being.",
        "follow-up": "Please schedule a follow-up appointment with your doctor as advised.",
        "telemedicine": "We offer telemedicine services for remote consultations. Contact us for more information.",
        "online services": "Our website provides various online services including appointment booking and medical records access.",
        "patient portal": "Access your medical information through our patient portal on our website.",
        "insurance plans": "We accept a variety of insurance plans. Contact our office for more details.",
        "payment options": "We offer multiple payment options including credit/debit cards and online payments.",
        "patient care": "Our team is dedicated to providing the best possible care for our patients.",
        "hospital amenities": "We provide various amenities to ensure a comfortable stay for our patients.",
        "healthcare providers": "Our healthcare providers are highly skilled and experienced in their respective fields.",
        "emergency services": "Our emergency services are available 24/7 for urgent medical needs.",
        "hospital reviews": "You can read reviews of our hospital on our website or other review platforms.",
        "patient feedback": "We appreciate patient feedback and use it to improve our services.",
        "staff credentials": "Our staff members are credentialed and licensed professionals in their fields.",
        "medical equipment": "We use state-of-the-art medical equipment to provide accurate diagnoses and treatments.",
        "hospital history": "Our hospital has a rich history of providing quality healthcare to the community.",
        "community outreach": "We engage in community outreach programs to promote health and wellness.",
        "research": "Our hospital participates in research initiatives to advance medical knowledge and treatments.",
        "training": "We offer training programs for healthcare professionals to stay current with medical advancements.",
        "volunteering": "Volunteer opportunities are available at our hospital. Contact us to learn more.",
        "donations": "Donations help support our hospital's programs and services. Visit our website for more information.",
        "patient support": "We provide various support services for patients and their families.",
        "emergency contact number": "For emergency contact, please call (123) 456-7890.",
        "facility tour": "Facility tours are available upon request. Contact us to schedule one.",
        "medication": "If you have questions about medication, please consult with your doctor or pharmacist.",
        "test results": "Test results are available through our patient portal or by contacting your healthcare provider.",
        "hospital services": "Our hospital offers a range of services including diagnostics, treatment, and rehabilitation.",
        "medical consultation": "Consultations are available with our specialists. Contact us to schedule an appointment.",
        "patient admission": "For patient admission, please contact our admissions department or visit our website.",
        "hospital policies": "Review our hospital policies on our website or contact us for more information.",
        "surgical procedures": "We perform various surgical procedures with the highest standards of care.",
        "patient safety": "We prioritize patient safety and follow strict protocols to ensure the best care.",
        "medical forms": "Medical forms can be obtained from our website or by contacting our office.",
        "hospital updates": "Stay updated with the latest news and events on our website.",
        "doctor availability": "Check the availability of our doctors on our website or contact our office.",
        "emergency care": "For emergency care, visit our emergency room or call 911.",
        "telehealth": "Telehealth services are available for remote consultations. Contact us for more details.",
        "patient services": "Our patient services team is available to assist with any questions or concerns.",
        "hospital amenities": "We offer various amenities for patient comfort including Wi-Fi and entertainment options.",
        "nursing care": "Our nursing staff provides compassionate care and support to patients throughout their stay.",
        "hospital admissions": "For hospital admissions, please contact our admissions department or visit our website.",
        "specialist consultation": "Consult with our specialists for expert medical advice and treatment options.",
        "family support": "We offer support services for patients' families to help them through the care process.",
        "health insurance": "For information about health insurance, please contact our office or visit our website.",
        "medical referrals": "Medical referrals can be arranged by contacting your healthcare provider or our office.",
        "medical billing": "For billing inquiries, please contact our billing department or visit our website.",
        "patient rights": "We uphold the highest standards of patient rights and privacy.",
        "hospital tours": "Schedule a tour of our hospital by contacting our front desk or visiting our website.",
        "wellness programs": "Participate in our wellness programs to enhance your health and well-being.",
        "hospital services": "Explore the range of services we offer by visiting our website or contacting our office.",
        "insurance coverage": "For details on insurance coverage, please contact our office or visit our website.",
        "medical records request": "Request medical records by contacting our records department or using our online portal.",
        "patient feedback": "Provide feedback on your experience by contacting us or using our online feedback form.",
        "hospital policies and procedures": "Review our hospital policies and procedures on our website or contact us for more information.",
        "health care providers": "Meet our team of healthcare providers and learn about their specialties on our website.",
        "emergency response": "In case of an emergency, contact 911 or visit our emergency room immediately.",
        "healthcare services": "We offer a range of healthcare services to meet your needs. Contact us for more details.",
        "hospital information": "Find information about our hospital including location, hours, and services on our website."
    };

    // Send message function
    function sendMessage() {
        const message = userInput.value.trim().toLowerCase();
        if (message) {
            // User message
            const userMessage = document.createElement('div');
            userMessage.classList.add('chat-message', 'user-message');
            userMessage.textContent = message;
            chatBody.appendChild(userMessage);
            userInput.value = '';

            // Bot response
            const botResponse = responses[message] || "Sorry, I didn't understand that.";
            const botMessage = document.createElement('div');
            botMessage.classList.add('chat-message', 'bot-message');
            botMessage.textContent = botResponse;
            chatBody.appendChild(botMessage);
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    }

    // Send message on button click
    sendBtn.addEventListener('click', sendMessage);

    // Send message on Enter key press
    userInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });
});
