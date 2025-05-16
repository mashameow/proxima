// Получаем DOM-элемент контейнера логотипов
const logosContainer = document.getElementById('logos')

// Если контейнера нет, ничего не делаем
if (logosContainer) {
	// Получаем лимит логотипов из data-атрибута, если есть
	const limit = parseInt(logosContainer.dataset.limit, 10) || null

	fetch('/../src/php/api/client_logos.php')
		.then(response => response.json())
		.then(data => {
			if (!Array.isArray(data)) {
				throw new Error('Неверный формат данных')
			}

			// Если лимит установлен — ограничиваем
			const logosToShow = limit ? data.slice(0, limit) : data

			logosToShow.forEach(logo => {
				const img = document.createElement('img')
				img.src = logo.url
				img.alt = logo.name
				img.classList.add('partnersAbout__block-img')
				logosContainer.appendChild(img)
			})
		})
		.catch(error => {
			console.error('Ошибка при загрузке логотипов:', error)
		})
}
