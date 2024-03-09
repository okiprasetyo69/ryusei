<div class="row">
    <div class="col-md-12">
        <!-- Floating Labels Form -->
        <form class="row g-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" placeholder="Kode SKU">
                    <label for="floatingName">Kode SKU</label>
                </div>
            </div>                                
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingEmail" placeholder="Nama Artikel">
                    <label for="floatingEmail">Nama Artikel</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingPassword" placeholder="Nama SKU">
                    <label for="floatingPassword">Nama SKU</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect" aria-label="State">
                        <option value="" >- Pilih Size - </option>
                        <option value="1">S</option>
                        <option value="2">M</option>
                        <option value="2">L</option>
                        <option value="2">XL</option>
                        <option value="2">XXL</option>
                        <option value="2">XXXL</option>
                    </select>
                    <label for="floatingSelect">Size</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <input type="number" min="0" class="form-control" id="floatingPassword" placeholder="Harga">
                    <label for="floatingTextarea">Harga</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingCity" placeholder="City">
                        <label for="floatingCity">Kategori</label>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating">
                    <fieldset class="row mb-3">
                        <legend class="col-form-label">Status</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                                <label class="form-check-label" for="gridRadios1">
                                    Ready
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                                <label class="form-check-label" for="gridRadios2">
                                    Not Ready
                                </label>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
        <!-- End floating Labels Form -->
    </div>
</div>