import { Injectable } from '@angular/core';
import { Observable, BehaviorSubject, interval } from 'rxjs';
import { take } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class TypewrittingService {

  private strings: string[] = [];
  private currentIndex = 0;
  private currentStringSubject = new BehaviorSubject<string>('');

  constructor() {}

  setStrings(strings: string[]): void {
    this.strings = strings;
    this.startChangingText();
  }

  getCurrentString(): Observable<string> {
    return this.currentStringSubject.asObservable();
  }
  
  private startChangingText(): void {
    interval(5000).subscribe(() => {
      this.currentStringSubject.next(this.strings[this.currentIndex]);
      this.currentIndex = (this.currentIndex + 1) % this.strings.length;
    });
  }
}
