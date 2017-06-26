Для установки виджета необходимо:
1. поместить папку виджета в директорию components приложения (хотя директория может быть и другой)
2. в настройках приложения (params.php) задать GooglePlaceApiKey ,  ключ для работы с API Google Place
3. в контроллере, в представлении которого будет вызов виджета, добавить метод
   ```
   public function actions()
    {
        return array(
            'address.' => 'application.components.addressManager.AddressManager',
        );
    }
    ```

Все функции, описанные в задании, виджет выполняет, хотя улучшить можно еще много чего. 
