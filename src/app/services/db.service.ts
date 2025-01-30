import { Injectable } from '@angular/core';
import * as mysql from 'mysql';
import { DbConfig } from '../../../config/db.config';

@Injectable({
  providedIn: 'root'
})
export class DbService {
  private connection;
  DbConfig = {
    PRDUCTION: false,
    HOST: 'localhost',
    USER: 'root',
    PASSWORD: '',
    DB: 'byontek'
  };
  
  constructor() { 
    this.connection = mysql.createConnection({
      host: this.DbConfig.HOST,
      user: this.DbConfig.USER,
      password: this.DbConfig.PASSWORD,
      database: this.DbConfig.DB
    });
    // Check connection status
    this.connection.connect((err) => {
      if (err) {
        console.error('Error connecting to MySQL:', err);
        return;
      }
      console.log('Connected to MySQL!');
    });
  }

  

  executeQuery(query: string, values?: any[]): Promise<any> {
    return new Promise((resolve, reject) => {
      this.connection.query(query, values, (error, results) => {
        if (error) {
          reject(error);
        } else {
          resolve(results);
        }
      });
    });
  }
}
