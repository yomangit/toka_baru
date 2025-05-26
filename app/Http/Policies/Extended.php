<?php
namespace App\Http\Policies;

use Spatie\Csp\Keyword;
use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;
use Illuminate\Support\Facades\Vite;
class Extended extends Basic
{
    public function configure()
    {
        parent::configure();
        
        $this->addDirective(Directive::STYLE, 'fonts.bunny.net');
        $this->addDirective(Directive::STYLE, 'fonts.googleapis.com');
        $this->addDirective(Directive::STYLE, 'css?family=figtree:400,500,600&display=swap');
        $this->addDirective(Directive::DEFAULT, 'fonts.gstatic.com');
        // $this->addDirective(Directive::SCRIPT, Keyword::SELF,'http://127.0.0.1:*');
     
    }
}