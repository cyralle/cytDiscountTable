# Rabatt plugin

Anhand einer Tabelle sollen sämtliche angezeigten Preise im Shop angepasst werden. Damit wird anhand einer Artikeleigenschaft und der Kundenklasse ein neuer Preis berechnet und angezeigt.

Die Preistabelle kann im Backend als CSV hochgeladen werden. (Aktuell in noch Arbeit)

Die ClickCounter Komponente ist nur als Test gedacht.

Die Tabelle wird aktuell als window.discountTable abgelegt.

Die resources/views/Scripts.twig ist nur ein Test zu nachträglichen Manipulation der Preise mit JS. Aktuell fehlt dort der Zugriff auf die Kundenklasse und die Artikeleigenschaft, da nicht klar ist, wie man die an dieser Stelle ermitteln kann.