# Test task

## Configuration of API
 

### Setup Google API OAuth Key
1. Navigate to Google Developers Console
2. Create a Google project or select already existed project.
3. Click Create credentials followed by OAuth client ID.
4. If necessary, Configure consent screen.
5. Set env variables
GOOGLE_CLIENT_ID
GOOGLE_CLIENT_SECRET


### Setup Google Service Account
1. Navigate to Google Developers Console
2. Create a new Service account key from Credentials.
3. Give your service account a name.
4. Under Grant this service account access to project step click on Select a Role dropdown and choose Project from left side and Editor from right side as shown in this image
5. Click Continue then Done.
6. Edit the service account and go to Keys tab.
7. Create a new Key of type JSON, and copy the json file to your project storage directory and rename it as credentials.json

 
### Create/Open a Google Spreadsheet file.
1. Give the sheet a name
2. Copy the ID of the document from file URL (e.g. https://docs.gogle.com/spreadsheets/d/{{SPREADSHEET_ID}}), 
3. Set it as env variable POST_SPREADSHEET_ID
4. Copy the Email of the recently created Service Account
5. Share the sheet with the Service Account email as Editor, see this image

### Enable required Google APIs
1. Navigate to Google Developers Console APIs Dashboard.
2. Click ENABLE API AND SERVICES.
3. Search for Google Drive API and Enable it.
4. Search for Google Sheets API and Enable it.


## Spin up container

You can spin up the container  via
```
docker run -it --rm -v <local_path>:/var/www/html/storage/data vmlavro/test4 bash
```
Where in *<local_path>* you should have local .xml file and credentials.json from 

## Run command
```
php artisan googleSheets:upload --source=local --localPath=coffee_feed.xml
```
or
```
php artisan googleSheets:upload --source=ftp --ftpServer=transport.productsup.io --ftpPath=coffee_feed.xml --ftpUser=pupDev --ftpPassword=pupDev2018
```
