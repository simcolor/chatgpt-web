const chatHistory = document.getElementById('chat-history');
const userInput = document.getElementById('user-input');
const sendButton = document.getElementById('send-button');
const chatForm = document.getElementById('chat-form');
const resetButton = document.getElementById('reset-button');

resetButton.addEventListener('click', () => {
const confirmation = confirm('Are you sure you want to clear the chat history?');
  if (!confirmation) return; 
	chatHistory.innerHTML = ''; // Clear the chat history
 localStorage.removeItem("history");
var xhr = new XMLHttpRequest();
  xhr.open("GET", "reset.php");
  xhr.send();
});



chatForm.addEventListener('submit', (event) => {
  event.preventDefault(); // Prevent the default form submission behavior
  const message = userInput.value;
  if (message) {
    showMessage(message, 'sent');
    userInput.value = '';
    userInput.style.height = '';
    const xhr = new XMLHttpRequest();
    xhr.open('POST', chatForm.action);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = () => {
      if (xhr.status === 200) {
        showMessage(xhr.responseText, 'received');
      }
    };
    xhr.send('text=' + encodeURIComponent(message));
  }
});


function showMessage(message, style) {
  const messageElement = document.createElement('div');
  messageElement.classList.add('message', style); // Add the 'received' class
  messageElement.innerHTML = message;
  chatHistory.appendChild(messageElement);
chatHistory.scrollTop = chatHistory.scrollHeight; // Scroll to the bottom
}

