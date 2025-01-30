import { Directive, ElementRef, Input, OnInit, Renderer2 } from '@angular/core';

@Directive({
  selector: '[appFliptext]',
  standalone: true
})
export class FliptextDirective {

  @Input('appFlipText') text: string = '';
  @Input() flipSpeed: number = 500; // Tiempo de duración del flip en milisegundos
  @Input() delayBetweenFlips: number = 100; // Tiempo de delay entre cada flip en milisegundos

  constructor(private el: ElementRef, private renderer: Renderer2) {}

  ngOnInit() {
    this.renderer.setProperty(this.el.nativeElement, 'textContent', '');
    this.startFlipping();
  }

  startFlipping() {
    let index = 0;

    const flip = () => {
      if (index < this.text.length) {
        const span = this.renderer.createElement('span');
        this.renderer.setStyle(span, 'display', 'inline-block');
        this.renderer.setStyle(span, 'transition', `transform ${this.flipSpeed}ms`);
        this.renderer.setStyle(span, 'transform', 'rotateX(90deg)');
        this.renderer.setProperty(span, 'textContent', this.text[index]);

        this.renderer.appendChild(this.el.nativeElement, span);

        setTimeout(() => {
          this.renderer.setStyle(span, 'transform', 'rotateX(0deg)');
        }, this.delayBetweenFlips * index);

        index++;
        setTimeout(flip, this.delayBetweenFlips);
      }
    };

    flip();
  }
}
