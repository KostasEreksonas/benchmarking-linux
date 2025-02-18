import { TestBed } from '@angular/core/testing';

import { BenchNameService } from './bench-name.service';

describe('BenchNameService', () => {
  let service: BenchNameService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BenchNameService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
