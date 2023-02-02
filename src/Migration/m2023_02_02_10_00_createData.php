<?php

namespace Migration;

class m2023_02_02_10_00_createData
{
	public static function up($connection): void
	{
		mysqli_query($connection,
			"INSERT INTO item (ID, NAME, SHORT_DESC, PRICE, FULL_DESC)
				VALUES (1, 'iPhone 12 Pro Max', 'Смартфон компании Apple', 54405, 'iPhone 12 Pro Max - это высококлассный смартфон от компании Apple, оснащенный мощным процессором A14 Bionic и большим 6,7-дюймовым дисплеем Super Retina XDR с разрешением 2778 x 1284 пикселей. В качестве системы защиты экрана используется Ceramic Shield, который увеличивает защиту от ударов и падений. Камера iPhone 12 Pro Max включает в себя три оптические модуля с различными функциями: 12-мегапиксельный основной модуль, 12-мегапиксельный широкоугольный модуль и 12-мегапиксельный телеобъектив. Также предусмотрена возможность записи видео в 4K формате с поддержкой HDR. iPhone 12 Pro Max оснащен 5G-поддержкой и возможностью зарядки без проводов.'),
					   (2, 'Samsung Galaxy S21 Ultra', 'Премиальный смартфон на Android', 64990, 'Samsung Galaxy S21 Ultra – это высокопроизводительный смартфон с потрясающим дизайном и высококачественным дисплеем. Он оснащен 6,8-дюймовым AMOLED-экраном с разрешением WQHD+ и частотой обновления 120 Гц. Внутри устройства находится мощный процессор Exynos 2100 или Snapdragon 888, в зависимости от региона, и 12 ГБ ОЗУ. Камера S21 Ultra является одной из лучших на рынке, с четырьмя основными камерами: 108-мегапиксельной основной камерой, 12-мегапиксельной телеобъективом, 12-мегапиксельным периферийным объективом и 10-мегапиксельным объективом с переменным фокусным расстоянием. Устройство также оснащено дополнительными функциями фото и видео, такими как 8K-видеосъемка, запись видео в реальном времени, панорамные снимки и многое другое.'),
					   (3, 'MacBook Air M2', 'Ноутбук Apple с микрочипом M1', 109990, 'MacBook Air M2 - это новейшая версия MacBook Air, оснащенная процессором Apple M2, который обеспечивает высокую производительность и быструю работу. Он имеет дисплей Retina с высоким разрешением, который предлагает яркие и живые цвета, а также технологию True Tone, которая адаптирует освещение экрана к окружающей среде. Он также оснащен камерой FaceTime HD, которая позволяет вам вести высококачественные видеозвонки, а также микрофоном и динамиком. Он оснащен аккумулятором, который предлагает длительный час работы без подзарядки. Таким образом, MacBook Air M2 - это идеальный компьютер для вашего дома или офиса, который предлагает высокую производительность, стильный дизайн и длительный час работы.'),
					   (4, 'Canon EOS R6', 'Профессиональная полнокадровая беззеркальная камера', 244000, 'Canon EOS R6 - это профессиональный зеркальный фотоаппарат с высокой производительностью. Он оснащен 20.1 мегапиксельной матрицей, которая позволяет снимать высококачественные изображения с широким диапазоном цветов и деталей. Он также оснащен процессором DIGIC X, который обеспечивает быструю обработку изображений и видео. Камера обладает функцией автофокуса с использованием инфракрасных датчиков, которые обеспечивают точный и быстрый автофокус. Он также может снимать видео в разрешении 4K 60 кадров в секунду. Canon EOS R6 оснащен встроенным видеостабилизатором, который позволяет снимать видео с меньшими растрепанными изображениями, даже при движении.'),
					   (5, 'Sony WH-1000XM4', 'Беспроводные наушники с шумоподавлением', 34999, 'Sony WH-1000XM4 это высококачественные беспроводные наушники с активным шумоподавлением, оснащенные новейшими технологиями. Они обеспечивают надежную и комфортную фиксацию на ухе и максимально бесшумный звук. Благодаря поддержке Bluetooth 5.0 и LDAC они обеспечивают высокое качество звука, а также дополнительные функции, такие как голосовые управление и интеллектуальный аудиорежим. С временем аккумуляции до 30 часов и встроенным микрофоном для звонков, Sony WH-1000XM4 - это идеальный выбор для людей, которые ценят качество звука и удобство.'),
					   (6, 'Nest Learning Thermostat', 'Умный термостат', 28940, 'Nest Learning Thermostat - это умный термостат, разработанный компанией Nest. Он использует интеллектуальный алгоритм для изучения ваших привычек и автоматически настраивает температуру вашего дома. Также можно управлять термостатом через мобильное приложение или голосовые команды через устройства типа Amazon Alexa или Google Home. Nest Learning Thermostat имеет элегантный дисплей с интуитивным интерфейсом и может экономить до 15% энергии.'),
					   (7, 'Amazon Echo Dot (4th Gen)', 'Умная колонка', 7576, 'Amazon Echo Dot (4th Gen) - это умный динамик, который работает с Amazon Alexa. Он имеет улучшенный звук и дизайн с текстурированным покрытием. С Echo Dot вы можете управлять умным домом, прослушивать музыку, получать информацию, настраивать напоминания и многое другое с помощью голосовых команд. Он также имеет встроенный усилитель и может быть использован с дополнительными динамиками для еще более мощного звука.');
");
		mysqli_query($connection,
			"INSERT INTO tag (ID, NAME)
				VALUES (1, 'телефоны'),
					   (2, 'ноутбуки'),
					   (3, 'фотоаппараты'),
					   (4, 'беспроводная гарнитура'),
					   (5, 'умный дом');");
		mysqli_query($connection,
			'INSERT INTO item_tag(ITEM_ID, TAG_ID)
				VALUES (1, 1),
					   (2, 1),
					   (3, 2),
					   (4, 3),
					   (5, 4),
					   (6, 5),
					   (7, 4),
					   (7, 5);');
	}

	public static function down($connection): void
	{
		//
	}
}