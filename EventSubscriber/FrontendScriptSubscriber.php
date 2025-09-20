<?php

namespace Skynettechnologies\Bundle\AllInOneAccessibilityBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FrontendScriptSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
    
    public function onKernelResponse(ResponseEvent $event): void
    {
        // Only modify master requests (not sub-requests, like profiler)
        if (!$event->isMainRequest()) {
            return;
        }
        $request  = $event->getRequest();
        $response = $event->getResponse();
    
        // Only modify full HTML pages
        if (stripos((string) $response->headers->get('Content-Type'), 'text/html') === false) {
            return;
        }
    
        // Exclude admin/backend area by path prefix (adjust if needed)
        $path = $request->getPathInfo();
        if (strpos($path, '/admin') === 0 || strpos($path, '/backend') === 0) {
            return;
        }
        
        $response = $event->getResponse();
        $content  = $response->getContent();
        
        
        // Inject script only into full HTML pages
        if (stripos($response->headers->get('Content-Type'), 'text/html') !== false) {
            $scriptTag = <<<HTML
<script id="aioa-adawidget" src="https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=#94944C&token=&position=bottom_right" defer></script>
HTML;
            
            // Inject before </body>
            $content = str_ireplace('</body>', $scriptTag . '</body>', $content);
            $response->setContent($content);
        }
    }
}
