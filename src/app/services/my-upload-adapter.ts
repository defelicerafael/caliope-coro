import { HttpClient } from '@angular/common/http';

export class MyUploadAdapter {
  constructor(private loader: any, private http: HttpClient) {}

  upload() {
    return this.loader.file.then((file: any) => {
      const formData = new FormData();
      formData.append('upload', file);

      return this.http.post('http://localhost/editorconimagenes/server/upload/guardar-imagen.php', formData).subscribe(
        (response) => {
          console.log('Upload successful:', response);
        },
        (error) => {
          console.error('Upload error:', error);
        }
      );
    });
  }

  abort() {
    console.error('Aborted');
  }
}