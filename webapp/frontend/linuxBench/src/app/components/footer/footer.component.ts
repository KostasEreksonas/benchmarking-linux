import { Component } from '@angular/core';
import {BenchResultsService} from '../../services/bench-results.service';

@Component({
  selector: 'app-footer',
  imports: [],
  templateUrl: './footer.component.html',
  styleUrl: './footer.component.css'
})
export class FooterComponent {
  public count = 0;

  public constructor(private benchService:BenchResultsService) {
    this.benchService.onResultCountChange.subscribe(()=>{
      this.count = this.benchService.resultsCount();
    })
  }
}
