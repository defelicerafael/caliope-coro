import { afterNextRender, Directive, ElementRef, Input, OnInit, Renderer2 } from '@angular/core';

@Directive({
  selector: '[appTypewriter]',
  standalone: true
})
export class TypewriterDirective {

  @Input('appTypewriter') text: string = '';
  @Input() typingSpeed: number = 35; // Velocidad de escritura en milisegundos
  @Input() delay: number = 0; // Tiempo de delay en milisegundos

  private observer: IntersectionObserver | undefined;

  constructor(private el: ElementRef, private renderer: Renderer2) {
    afterNextRender(() => {
      this.renderer.setProperty(this.el.nativeElement, 'textContent', '');

      if (typeof IntersectionObserver !== 'undefined') {
        // Configura el IntersectionObserver
        const options: IntersectionObserverInit = {
          root: null,
          threshold: 0.5 // Puedes ajustar este valor según tus necesidades
        };

        this.observer = new IntersectionObserver((entries) => this.handleIntersection(entries), options);
        this.observer.observe(this.el.nativeElement);
      } else {
        console.error('IntersectionObserver is not supported.'); // Maneja el caso donde IntersectionObserver no está soportado
      }
    });
  }

  ngOnInit() {}

  ngOnDestroy() {
    if (this.observer) {
      this.observer.disconnect();
    }
  }

  private handleIntersection(entries: IntersectionObserverEntry[]) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          this.typeWriterEffect(this.text, this.typingSpeed);
        }, this.delay);
        this.observer?.disconnect(); // Dejar de observar una vez que se ha iniciado la animación
      }
    });
  }

  // Método para la animación de escritura de texto
  private typeWriterEffect(text: string, speed: number) {
    let index = 0;

    const type = () => {
      if (index < text.length) {
        this.renderer.setProperty(this.el.nativeElement, 'textContent', text.substring(0, index + 1));
        index++;
        setTimeout(type, speed);
      }
    };

    type();
  }
}